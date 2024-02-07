<?php

namespace App\Console\Commands;

use App\Models\Studio;
use App\Models\WorkDescriptionAuthor;
use App\Models\WorkDescription;
use App\Models\ExternalReferenceType;
use App\Models\Language;
use App\Models\Work;
use App\Models\WorkType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportOldDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compendium:import-old-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the old compendium database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('migrate:fresh');
        $this->call('db:seed', ['--class' => 'Database\Seeders\DatabaseSeeder']);

        $this->info('Importing old database...');
        $this->cleanupOldDb();
        $this->importAuthors();
        $this->importWorkTypes();
        $this->importStudios();
        $this->importWorks();
    }

    /**
     * Cleans the old database up
     * @return void
     */
    public function cleanupOldDb(): void
    {
        DB::connection('old')->statement('PRAGMA foreign_keys = 0;');

        // Deletes a record containing the headings
        DB::connection('old')->table('film')->where(['id' => 'id'])->delete();

        // Make the first letter of the author name uppercase
        DB::connection('old')->statement("UPDATE film set aut_descrizione = UPPER(SUBSTR(aut_descrizione, 1, 1)) || SUBSTR(aut_descrizione, 2) where aut_descrizione is not null");

        // Nullfies the almost-null author names
        DB::connection('old')->table('film')->whereIn('aut_descrizione', ['', '2669', 'NULL'])->update(['aut_descrizione' => null]);

        // Cleans errors up
        DB::connection('old')->table('film')->where('id', '=', 'TheAbsentMindedProfessor ')->update(['id' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('a_film_liste')->where('id_film', '=', 'TheAbsentMindedProfessor ')->update(['id_film' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('a_film_persone')->where('id_film', '=', 'TheAbsentMindedProfessor ')->update(['id_film' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('a_film_studio')->where('id_film', '=', 'TheAbsentMindedProfessor ')->update(['id_film' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('film')->delete('');
    }

    /**
     * Imports authors from the old database.
     *
     * @return void
     */
    private function importAuthors(): void
    {
        DB::connection('old')->table('film')->select(['aut_descrizione'])->distinct()->get()->reduce(function ($authors, $record) {
            collect(explode(',', $record->aut_descrizione))->each(fn(string $author) => $authors->push(trim($author) ?: null));
            return $authors->unique();
        }, collect())->each(function ($author) {
            if ($author !== null) {
                (new WorkDescriptionAuthor(['name' => $author]))->save();
            }
        });
    }

    /**
     * Imports the work types table from the old database
     */
    private function importWorkTypes(): void
    {
        DB::connection('old')->table('film')->select(['type'])->distinct()->get()->each(function (object $record) {
            if (trim($record->type)) {
                (new WorkType([
                    'name' => Str::ucfirst($record->type),
                    'slug' => Str::lower($record->type),
                ]))->save();
            }
        });
    }

    /**
     * Imports the studios from the old database
     */
    private function importStudios(): void
    {
        DB::connection('old')->table('studios')->get()->each(function (object $record) {
            (new Studio([
                'name' => $record->nome,
                'slug' => $record->id,
            ]))->save();
        });
    }

    /**
     * Imports the works table from the old database
     * @return void
     */
    private function importWorks(): void
    {
        $externalReferenceTypes = ExternalReferenceType::pluck('id', 'slug')->toArray();
        $workTypes = WorkType::pluck('id', 'slug')->toArray();
        $authors = WorkDescriptionAuthor::pluck('id', 'name')->toArray();
        $languages = Language::pluck('id', 'iso_639_1')->toArray();
        $studios = Studio::pluck('id', 'slug')->toArray();

        DB::connection('old')->table('film')->select('*')->get()->each(function ($record) use ($studios, $workTypes, $authors, $externalReferenceTypes, $languages) {
            // Manages years in the form "YYYY - YYYY"
            if (count(explode(' - ', $record->anno)) == 2) {
                list($record->anno, $record->{'anno-fine'}) = explode(' - ', $record->anno);
            }

            // Manages years in the form "DD/MM/YYYY"
            if (count(explode('-', $record->anno)) == 3) {
                $record->data = $record->anno;
                $record->anno = explode('-', $record->anno)[0];
            }

            // Manages years in the form "YYYY/YY" or "YYYY/YYYY"
            if (count(explode('/', $record->anno)) == 2) {
                $exploded = explode('/', $record->anno);
                $record->anno = $exploded[0];
                $record->{'anno-fine'} = (int)$exploded[1] < 100 ? (int)$exploded[1] + 1900 : $exploded[1];
            }

            // Manages the null values
            foreach ($record as $key => $value) {
                $record->{$key} = (Str::lower($value) == 'null' or !$value) ? null : $value;
            }

            // Removes non-numeric values from the year
            $record->anno = is_numeric($record->anno) ? $record->anno : null;

            $work = new Work([
                'slug'                 => $record->id,
                'year'                 => $record->anno ?: null,
                'date'                 => $record->data ?? null,
                'end_year'             => $record->{'anno-fine'} ?: null,
                'contains_episodes'    => self::isTrue($record->episodi),
                'length'               => $record->durata,
                'is_description_ready' => self::isTrue($record->pronto),
                'is_accessible'        => self::isTrue($record->pervenuto),
                'is_available'         => self::isTrue($record->disponibile),
                'is_published'         => self::isTrue($record->uscito),
                'work_type_id'         => trim($record->type) ? $workTypes[Str::lower($record->type)] : null,
                'utils'                => json_encode([
                    'numbering' => $record->{'util-numerazione'},
                    'link'      => $record->{'util-link'},
                    'reference' => $record->reference,
                ]),
            ]);
            $work->save();

            if ($record->titolo) {
                $work->titles()->create([
                    'title'       => $record->titolo,
                    'language_id' => $languages['it'],
                ]);
            }

            if ($record->{'titolo-en'}) {
                $work->titles()->create([
                    'title'       => $record->{'titolo-en'},
                    'language_id' => $languages['en'],
                ]);
            }

            if ($record->{'titolo-orig'}) {
                $work->titles()->create([
                    'title'       => $record->{'titolo-orig'},
                    'language_id' => $languages['xx'],
                ]);
            }

            if ($record->topic) {
                $work->external_references()->create([
                    'external_reference_type_id' => $externalReferenceTypes['forum'],
                    'url'                        => $record->topic,
                ]);
            }

            foreach (['amazon', 'youtube', 'inducks', 'disneyplus', 'steam', 'netflix'] as $media) {
                if ($record->{$media}) {
                    $work->external_references()->create([
                        'external_reference_type_id' => $externalReferenceTypes[$media],
                        'url'                        => $record->{$media},
                    ]);
                }
            }

            if ($record->descrizione) {
                $description = new WorkDescription([
                    'work_id'     => $work->id,
                    'language_id' => $languages['it'],
                    'description' => $record->descrizione
                ]);
                $description->save();

                if ($record->aut_descrizione) {
                    collect(explode(',', $record->aut_descrizione))->each(fn(string $author) => $description->authors()->attach($authors[trim($author)]));
                }
            }

            DB::connection('old')->table('a_film_studio')->select('*')->where('id_film', '=', $work->slug)->get()->each(function ($studio) use ($work, $studios) {
                if(isset($studios[$studio->id_studio])) {
                    $work->studios()->attach($studios[$studio->id_studio]);
                }
            });
        });
    }

    private static function isTrue(mixed $value): bool
    {
        return (!!$value or Str::lower($value) == 'true');
    }
}
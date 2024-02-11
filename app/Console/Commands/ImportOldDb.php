<?php

namespace App\Console\Commands;

use App\Models\CastMember;
use App\Models\CastRole;
use App\Models\Studio;
use App\Models\WorkCastMembership;
use App\Models\WorkDescriptionAuthor;
use App\Models\WorkDescription;
use App\Models\ExternalReferenceType;
use App\Models\Language;
use App\Models\Work;
use App\Models\WorkEpisode;
use App\Models\WorkList;
use App\Models\WorkListDetail;
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

        $this->info('Preparing the databases.');
        $this->cleanupOldDb();
        DB::statement('ALTER TABLE external_reference_types ADD COLUMN slug varchar(255) null AFTER id');
        DB::statement('ALTER TABLE studios ADD COLUMN slug varchar(255) null AFTER id');
        DB::statement('ALTER TABLE work_types ADD COLUMN slug varchar(255) null AFTER id');
        DB::statement('ALTER TABLE cast_members ADD COLUMN slug varchar(255) null AFTER id');
        DB::statement('ALTER TABLE cast_roles ADD COLUMN slug varchar(255) null AFTER id');

        foreach (['forum', 'amazon', 'youtube', 'inducks', 'disneyplus', 'steam', 'netflix'] as $id => $slug) {
            DB::table('external_reference_types')->where(['id' => $id + 1])->update(['slug' => $slug]);
        }

        $this->info('Importing authors.');
        $this->importAuthors();

        $this->info('Importing work types.');
        $this->importWorkTypes();

        $this->info('Importing studios.');
        $this->importStudios();

        $this->info('Importing lists.');
        $this->importLists();

        $this->info('Importing cast members.');
        $this->importCastMembers();

        $this->info('Importing cast roles.');
        $this->importCastRoles();

        $this->info('Importing works.');
        $this->importWorks();

        $this->info('Cleaning up.');
        DB::connection('mysql')->statement('ALTER TABLE external_reference_types DROP COLUMN slug');
        DB::connection('mysql')->statement('ALTER TABLE studios DROP COLUMN slug');
        DB::connection('mysql')->statement('ALTER TABLE work_types DROP COLUMN slug');
        DB::connection('mysql')->statement('ALTER TABLE cast_members DROP COLUMN slug');
        DB::connection('mysql')->statement('ALTER TABLE cast_roles DROP COLUMN slug');

        $this->info('Done.');
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

        // Replaces first-level and third-level headings with second-level headings
        DB::connection('old')->statement("UPDATE film SET descrizione = REPLACE(descrizione, '<h1>', '<h2>')");
        DB::connection('old')->statement("UPDATE film SET descrizione = REPLACE(descrizione, '</h1>', '</h2>')");
        DB::connection('old')->statement("UPDATE film SET descrizione = REPLACE(descrizione, '<h3>', '<h2>')");
        DB::connection('old')->statement("UPDATE film SET descrizione = REPLACE(descrizione, '</h3>', '</h2>')");

        // Cleans errors up
        DB::connection('old')->table('film')->where('id', '=', 'TheAbsentMindedProfessor ')->update(['id' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('a_film_liste')->where('id_film', '=', 'TheAbsentMindedProfessor ')->update(['id_film' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('a_film_persone')->where('id_film', '=', 'TheAbsentMindedProfessor ')->update(['id_film' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('a_film_studio')->where('id_film', '=', 'TheAbsentMindedProfessor ')->update(['id_film' => 'TheAbsentMindedProfessor2']);
        DB::connection('old')->table('film')->delete('');
        DB::connection('old')->table('a_film_persone')->where('id_persona', '=', 'AndtEngman')->update(['id_persona' => 'AndyEngman']);
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
                    'name' => Str::lower($record->type),
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
     * Imports the studios from the old database
     */
    private function importLists(): void
    {
        $languages = Language::pluck('id', 'iso_639_1')->toArray();
        $this->withProgressBar(DB::connection('old')->table('liste')->get(), function (object $record) use ($languages) {
            $list = new WorkList([
                'slug' => $record->id,
            ]);
            $list->save();

            if (trim($record->nome_it)) {
                $exploded = explode("\n", $record->nome_it);
                $detail = new WorkListDetail([
                    'work_list_id' => $list->id,
                    'language_id'  => $languages['it'],
                    'name'         => $exploded[0],
                ]);
                if (count($exploded) > 1) {
                    $detail->notes = trim(implode(array_slice($exploded, 1))) . "\n";
                }
                $detail->save();
            }

            if (trim($record->nome_en)) {
                $exploded = explode("\n", $record->nome_en);
                $detail = new WorkListDetail([
                    'work_list_id' => $list->id,
                    'language_id'  => $languages['en'],
                    'name'         => $exploded[0],
                ]);
                if (count($exploded) > 1) {
                    $detail->notes = trim(implode(array_slice($exploded, 1))) . "\n";
                }
                $detail->save();
            }
        });
        $this->line('');
    }

    /**
     * Imports the cast members from the old database
     * @return void
     */
    private function importCastMembers(): void
    {
        $this->withProgressBar(DB::connection('old')->table('persone')->get(), function (\stdClass $castMember) {
            (new CastMember([
                'slug'    => $castMember->id,
                'name'    => $castMember->nome,
                'surname' => $castMember->cognome,
            ]))->save();
        });
        $this->line('');
    }

    /**
     * Imports the cast roles from the old database
     * @return void
     */
    private function importCastRoles(): void
    {
        $languages = Language::pluck('id', 'iso_639_1')->toArray();
        DB::connection('old')->table('ruoli')->get()->each(function (\stdClass $castRole) use ($languages) {
            $newCastRole = new CastRole(['slug' => $castRole->id]);
            $newCastRole->save();
            if (trim($castRole->ita)) {
                $newCastRole->cast_role_details()->create([
                    'name'        => $castRole->ita,
                    'language_id' => $languages['it'],
                ]);
            }
            if (trim($castRole->en)) {
                $newCastRole->cast_role_details()->create([
                    'name'        => $castRole->en,
                    'language_id' => $languages['en'],
                ]);
            }
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
        $lists = WorkList::pluck('id', 'slug')->toArray();
        $castMembers = CastMember::pluck('id', 'slug')->toArray();
        $castRoles = CastRole::pluck('id', 'slug')->toArray();

        $this->withProgressBar(DB::connection('old')->table('film')->select('*')->get(),
            function ($record) use ($castMembers, $castRoles, $lists, $studios, $workTypes, $authors, $externalReferenceTypes, $languages) {
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

                // Creates base Work record
                $work = new Work([
                    'slug'              => $record->id,
                    'year'              => $record->anno ?: null,
                    'date'              => $record->data ?? null,
                    'end_year'          => $record->{'anno-fine'} ?: null,
                    'contains_episodes' => self::isTrue($record->episodi),
                    'length'            => $record->durata,
                    'is_accessible'     => self::isTrue($record->pervenuto),
                    'is_available'      => self::isTrue($record->disponibile),
                    'is_lost'           => $record->disponibile == 'lost',
                    'is_published'      => self::isTrue($record->uscito),
                    'work_type_id'      => trim($record->type) ? $workTypes[Str::lower($record->type)] : null,
                    'utils'             => json_encode([
                        'numbering' => $record->{'util-numerazione'},
                        'link'      => $record->{'util-link'},
                        'reference' => $record->reference,
                    ]),
                ]);
                $work->save();

                // Imports Italian title if available
                if ($record->titolo) {
                    $work->titles()->create([
                        'title'       => $record->titolo,
                        'language_id' => $languages['it'],
                    ]);
                }

                // Imports (hopefully) English title if available
                if ($record->{'titolo-en'}) {
                    $work->titles()->create([
                        'title'       => $record->{'titolo-en'},
                        'language_id' => $languages['en'],
                    ]);
                }

                // Imports "original" title if available
                if ($record->{'titolo-orig'}) {
                    $work->titles()->create([
                        'title'       => $record->{'titolo-orig'},
                        'language_id' => $languages['xx'],
                    ]);
                }

                // Imports external reference to the Sollazzo forum
                if ($record->topic) {
                    $work->external_references()->create([
                        'external_reference_type_id' => $externalReferenceTypes['forum'],
                        'url'                        => $record->topic,
                    ]);
                }

                // Import other external references
                foreach (['amazon', 'youtube', 'inducks', 'disneyplus', 'steam', 'netflix'] as $media) {
                    if ($record->{$media}) {
                        $work->external_references()->create([
                            'external_reference_type_id' => $externalReferenceTypes[$media],
                            'url'                        => $record->{$media},
                        ]);
                    }
                }

                // Imports the Italian work description, splitting it into parts based on the headings
                if ($record->descrizione) {
                    $description = new WorkDescription([
                        'work_id'     => $work->id,
                        'language_id' => $languages['it'],
                        'is_ready'    => self::isTrue($record->pronto),
                    ]);
                    $description->save();

                    $descriptionParts = explode("<h2", $record->descrizione);
                    foreach ($descriptionParts as $key => $part) {
                        if (trim($part) == '') {
                            continue;
                        }

                        $part = '<h2' . $part;
                        $title = Str::between($part, '<h2>', '</h2>');
                        $content = Str::after($part, '</h2>');
                        $description->work_description_parts()->create([
                            'part_no' => $key + 1,
                            'title'   => trim($title),
                            'content' => trim($content),
                        ]);
                    }

                    if ($record->aut_descrizione) {
                        collect(explode(',', $record->aut_descrizione))->each(fn(string $author) => $description->authors()->attach($authors[trim($author)]));
                    }
                }

                // Imports the relation with studios
                DB::connection('old')->table('a_film_studio')->select('*')->where('id_film', '=', $work->slug)->get()->each(function ($studio) use ($work, $studios) {
                    if (isset($studios[$studio->id_studio])) {
                        $work->studios()->attach($studios[$studio->id_studio]);
                    }
                });

                // Imports the relation with lists
                DB::connection('old')->table('a_film_liste')->select('*')->where('id_film', '=', $work->slug)->get()->each(function ($list) use ($work, $lists) {
                    if (isset($lists[$list->id_lista])) {
                        $work->work_lists()->attach($lists[$list->id_lista], ((int)$list->ordine or (int)$list->ordine === 0) ? ['order' => (int)$list->ordine] : []);
                    }
                });

                // Imports the relation with episodes
                DB::connection('old')->table('episodi')->select('*')->where('id_film', '=', $work->slug)->get()->each(function ($episode) use ($languages, $work) {
                    $newEpisode = new WorkEpisode([
                        'work_id' => $work->id,
                        'number'  => $episode->episodio,
                    ]);
                    $newEpisode->save();

                    if (trim($episode->titolo)) {
                        $newEpisode->work_episode_titles()->create([
                            'title'       => $episode->titolo,
                            'language_id' => $languages['it'],
                        ]);
                    }

                    if (trim($episode->titolo_en)) {
                        $newEpisode->work_episode_titles()->create([
                            'title'       => $episode->titolo_en,
                            'language_id' => $languages['en'],
                        ]);
                    }
                });

                // Imports the relation with cast members
                DB::connection('old')->table('a_film_persone')->select('*')->where('id_film', '=', $work->slug)->get()->each(function ($cast_lnk) use ($castRoles, $castMembers, $work) {
                    if (!isset($castMembers[$cast_lnk->id_persona])) {
                        $exploded = preg_split('/(?=[A-Z])/', $cast_lnk->id_persona);
                        $newMember = new CastMember([
                            'name'     => count($exploded) > 2 ? $exploded[1] : null,
                            'surname'  => count($exploded) > 2 ? implode(' ', array_slice($exploded, 2)) : null,
                            'pen_name' => count($exploded) == 2 ? $exploded[1] : null,
                        ]);
                        $newMember->save();
                        $castMembers[$cast_lnk->id_persona] = $newMember->id;
                    }

                    if (!isset($castRoles[$cast_lnk->ruolo])) {
                        return;
                    }

                    (new WorkCastMembership([
                        'work_id'         => $work->id,
                        'cast_member_id'  => $castMembers[$cast_lnk->id_persona],
                        'cast_role_id'    => $castRoles[$cast_lnk->ruolo],
                        'work_episode_id' => $cast_lnk->episodio ? (WorkEpisode::where('work_id', $work->id)->where('number', $cast_lnk->episodio)->first()->id ?? null) : null,
                        'notes'           => trim($cast_lnk->note) ? $cast_lnk->note : null,
                    ]))->save();
                });
            });
        $this->line('');
    }

    private static function isTrue(mixed $value): bool
    {
        return ($value === true or $value === 1 or Str::lower($value) == 'true' or Str::lower($value) == 'yes');
    }
}

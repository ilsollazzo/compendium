<?php

namespace Database\Seeders;

use App\Models\ExternalReferenceType;
use App\Models\Language;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedExternalReferenceTypes();
        $this->seedLanguages();
    }

    private function seedExternalReferenceTypes(): void
    {
        collect([
            [
                'name' => 'Forum',
                'url_model' => 'http://www.ilsollazzo.com/forum/viewtopic.php?t=:replace:',
            ],
            [
                'name' => 'Amazon',
                'url_model' => ':replace:',
            ],
            [
                'name' => 'Youtube',
                'url_model' => 'http://youtu.be/:replace:',
            ],
            [
                'name' => 'I.N.D.U.C.K.S.',
                'url_model' => 'https://inducks.org/story.php?c=:replace:',
            ],
            [
                'name' => 'Disney+',
                'url_model' => 'https://www.disneyplus.com/movies/wd/:replace:',
            ],
            [
                'name' => 'Steam',
                'url_model' => 'https://store.steampowered.com/app/:replace:',
            ],
            [
                'name' => 'Netflix',
                'url_model' => 'https://www.netflix.com/title/:replace:',
            ],
        ])->each(fn(array $externalReferenceType) => (new ExternalReferenceType($externalReferenceType))->save());
    }

    private function seedLanguages(): void
    {
        collect([
            [
                'iso_639_1' => 'xx',
            ],
            [
                'iso_639_1' => 'en',
            ],
            [
                'iso_639_1' => 'it',
            ],
        ])->each(fn(array $language) => (new Language($language))->save());
    }
}

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
            ],
            [
                'name' => 'Website',
            ],
            [
                'name' => 'Youtube',
            ],
            [
                'name' => 'I.N.D.U.C.K.S.',
            ],
            [
                'name' => 'Disney+',
            ],
            [
                'name' => 'Steam',
            ],
            [
                'name' => 'Netflix',
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

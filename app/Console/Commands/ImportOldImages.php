<?php

namespace App\Console\Commands;

use App\Models\Work;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class ImportOldImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compendium:import-old-images {--y|yes} {--skip-thumbnails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!$this->option('yes') && !$this->confirm('This command should be run after populating the database (either with compendium:import-old-db or manually). Is the db populated?')) {
            return;
        }

        $this->withProgressBar(Work::all(), function ($work) {
            // Import thumbnail
            if (!$this->option('skip-thumbnails')) {
                self::importThumbnail($work);
            }
        });
    }

    private static function importThumbnail(Work $work): void
    {
        $base_url = "https://www.ilsollazzo.com/c/disney/images/frames/{$work->slug}";
        $extension = self::getRightExtension($base_url);

        if($extension) {
            $image = (new ImageManager(new Driver()))->read(Http::get("{$base_url}.{$extension}")->body())->resizeDown(width: 400);

            $image->toWebp()->save(config('filesystems.disks.works_thumbnails.root') . "/{$work->id}.webp");
        }
    }

    /**
     * Hints the right extension for an image
     * @param string $base_url
     * @return string
     */
    private static function getRightExtension(string $base_url): ?string
    {
        foreach (['jpg', 'png', 'jpeg', 'bmp'] as $extension) {
            $response = Http::head("{$base_url}.{$extension}");
            if ($response->successful()) {
                return $extension;
            }
        }
        return null;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Work;
use App\Models\WorkDescriptionPart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Laravel\Facades\Image;

class ImportOldImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compendium:import-old-images {--y|yes} {--skip-thumbnails} {--skip-titles} {--skip-body-images} {--skip-posters}';

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
                $this->importThumbnail($work);
            }
            if (!$this->option('skip-titles') and $work->descriptions->count()) {
                $this->importTitle($work);
            }
            if (!$this->option('skip-body-images') and $work->descriptions->count()) {
                $this->importBodyImages($work);
            }
            if (!$this->option('skip-posters') and $work->descriptions->count()) {
                $this->importPosters($work);
            }
        });
    }

    private function importThumbnail(Work $work): void
    {
        $base_url = "https://www.ilsollazzo.com/c/disney/images/frames/{$work->slug}";
        $extension = self::getRightExtension($base_url);

        if($extension) {
            $this->writeImageToDisk("{$base_url}.{$extension}", 'works_thumbnails', "{$work->id}.webp");
        }
    }

    private function importTitle(Work $work): void
    {
        $base_url = "https://www.ilsollazzo.com/c/disney/images/titlecards/{$work->slug}";
        $extension = self::getRightExtension($base_url);

        if($extension) {
            $this->writeImageToDisk("{$base_url}.{$extension}", 'works_titles', "{$work->id}.webp");
        }
    }

    private function importPosters(Work $work): void
    {
        $base_url = "https://www.ilsollazzo.com/c/disney/images/posters/{$work->slug}";
        $extension = self::getRightExtension($base_url);

        if($extension) {
            $this->writeImageToDisk("{$base_url}.{$extension}", 'works_posters', "{$work->id}.webp");
        }
    }



    private function importBodyImages(Work $work): void
    {
        $work->descriptions->first()->description_parts->each(function (WorkDescriptionPart $section) use ($work) {
            $partNo = str_pad($section->part_no, 2, '0', STR_PAD_LEFT);
            $base_url = "https://www.ilsollazzo.com/c/disney/images/articles/{$work->slug}/{$partNo}";
            $extension = self::getRightExtension($base_url);
            if($extension) {
                self::writeImageToDisk("{$base_url}.{$extension}", 'works_description_parts', "{$section->id}.webp");
            }
        });

        $footerNo = str_pad($work->descriptions->first()->description_parts->last()->part_no + 1, 2, '0', STR_PAD_LEFT);
        $base_url = "https://www.ilsollazzo.com/c/disney/images/articles/{$work->slug}/{$footerNo}";
        $extension = self::getRightExtension($base_url);
        if($extension) {
            $this->writeImageToDisk("{$base_url}.{$extension}", 'works_footers', "{$work->id}.webp");
        }
    }

    /**
     * Hints the right extension for an image
     * @param string $base_url
     * @return ?string
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

    /**
     * @param string $url
     * @param string $disk
     * @param string $fileName
     * @return void
     */
    private function writeImageToDisk(string $url, string $disk, string $fileName): void
    {
        ini_set('memory_limit', '512M');
        try {
            $image = Image::read(Http::get($url)->body());
            $image->toWebp()->save(config("filesystems.disks.{$disk}.root") . "/{$fileName}");
            unset($image);
        } catch (\Throwable $exception) {
            $this->error("Disk: {$disk} - Url: {$url} - Exception: {$exception->getMessage()}");
        }

    }
}

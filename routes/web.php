<?php

use App\Models\Work;
use App\Models\WorkDescription;
use App\Models\WorkDescriptionPart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('welcome');
});

# Works
Route::get('/works/{slug}/thumbnail.webp', function (string $slug) {
    $work = Work::firstWhere('slug', '=', $slug);
    if ($work and Storage::disk('works_thumbnails')->exists("{$work->id}.webp")) {
        $file = Storage::disk('works_thumbnails')->get("{$work->id}.webp");

        return response($file)->withHeaders([
            'Content-Type'   => 'image/webp',
            'Content-Length' => strlen($file),
        ]);
    } else {
        abort(404);
    }
})->name('works.thumbnail');

Route::get('/works/{slug}/title.webp', function (string $slug) {
    $work = Work::firstWhere('slug', '=', $slug);
    if ($work and Storage::disk('works_titles')->exists("{$work->id}.webp")) {
        $file = Storage::disk('works_titles')->get("{$work->id}.webp");

        return response($file)->withHeaders([
            'Content-Type'   => 'image/webp',
            'Content-Length' => strlen($file),
        ]);
    } else {
        abort(404);
    }
})->name('works.title');

Route::get('/works/{slug}/footer.webp', function (string $slug) {
    $work = Work::firstWhere('slug', '=', $slug);
    if ($work and Storage::disk('works_footers')->exists("{$work->id}.webp")) {
        $file = Storage::disk('works_footers')->get("{$work->id}.webp");

        return response($file)->withHeaders([
            'Content-Type'   => 'image/webp',
            'Content-Length' => strlen($file),
        ]);
    } else {
        abort(404);
    }
})->name('works.footer');

Route::get('/works/{slug}/poster.webp', function (string $slug) {
    $work = Work::firstWhere('slug', '=', $slug);
    if ($work and Storage::disk('works_posters')->exists("{$work->id}.webp")) {
        $file = Storage::disk('works_posters')->get("{$work->id}.webp");

        return response($file)->withHeaders([
            'Content-Type'   => 'image/webp',
            'Content-Length' => strlen($file),
        ]);
    } else {
        abort(404);
    }
})->name('works.poster');

Route::get('/works/{slug}/descriptions/{work_description}/parts/{work_description_part}/image.webp', function (string $slug, WorkDescription $workDescription, WorkDescriptionPart $workDescriptionPart) {
    if (Storage::disk('works_description_parts')->exists("{$workDescriptionPart->id}.webp")) {
        $file = Storage::disk('works_description_parts')->get("{$workDescriptionPart->id}.webp");

        return response($file)->withHeaders([
            'Content-Type'   => 'image/webp',
            'Content-Length' => strlen($file),
        ]);
    } else {
        abort(404);
    }
})->name('works.descriptions.parts.image');

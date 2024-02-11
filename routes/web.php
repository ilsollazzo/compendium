<?php

use App\Models\Work;
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

Route::get('/', function () {
    return view('welcome');
});

# Works
Route::get('/works/{slug}/thumbnail.webp', function (string $slug) {
    $work = Work::firstWhere('slug', '=', $slug);
    if($work and Storage::disk('works_thumbnails')->exists("{$work->id}.webp")) {
        $file = Storage::disk('works_thumbnails')->get("{$work->id}.webp");

        return response($file)->withHeaders([
            'Content-Type' => 'image/webp',
            'Content-Length' => strlen($file),
        ]);
    } else {
        abort(404);
    }
})->name('work.thumbnail');

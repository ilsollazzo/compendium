<?php

use App\Http\Resources\WorkResource;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', fn() => redirect('/'));

/**
 * WORKS
 */
Route::get('/works', function () {
    return WorkResource::collection(Work::paginate());
})->name('api.work.index');
Route::get('/works/{slug}', function (string $slug) {
    return new WorkResource(Work::where('slug', $slug)->firstOrFail());
})->name('api.works.show');

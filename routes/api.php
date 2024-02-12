<?php

use App\Http\Resources\WorkListResource;
use App\Http\Resources\WorkResource;
use App\Models\Work;
use App\Models\WorkList;
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
    return new WorkResource(Work::where('slug', $slug)->with(['studios', 'descriptions', 'work_lists', 'external_references', 'episodes', 'cast_memberships'])->firstOrFail());
})->name('api.works.show');

/**
 * LISTS
 */
Route::get('/lists', function () {
    return WorkListResource::collection(Work::paginate());
})->name('api.list.index');
Route::get('/lists/{slug}', function (string $slug) {
    return new WorkListResource(WorkList::where('slug', $slug)->with('works')->firstOrFail());
})->name('api.list.show');

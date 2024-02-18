<?php

use App\Http\Controllers\Admin\Dashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

Route::get('/', [Dashboard::class, 'index'])->name('admin');


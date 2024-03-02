<?php

use App\Http\Controllers\Admin\Dashboard;
use App\Livewire\Admin\Works\IndexWorks;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/

Route::get('/', [Dashboard::class, 'index'])->name('admin');

Route::get('/works', IndexWorks::class)->name('admin.works.index');

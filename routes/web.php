<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import-view', function () {
    return view('import-vue');
});

Route::get('/export-view', function () {
    return view('export');
});


Route::post('/import-excel', [UsersController::class, 'import'])->name('import.xlsx');
Route::get('/export-excel', [UsersController::class, 'export'])->name('export.xlsx');

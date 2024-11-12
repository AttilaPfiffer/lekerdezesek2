<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
//levélküldés
Route::get('send-mail', [MailController::class, 'index']);
//file feltoltes
Route::get('file-upload', [FileController::class, 'index']);
Route::post('file-upload', [FileController::class, 'store'])->name('file.store');

require __DIR__.'/auth.php';

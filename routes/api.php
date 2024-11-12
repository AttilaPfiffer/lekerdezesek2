<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Librarian;
use App\Http\Middleware\Warehouseman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//bárki által elérhető
Route::post('/register',[RegisteredUserController::class, 'store']);
Route::post('/login',[AuthenticatedSessionController::class, 'store']);

//összes kérés
Route::apiResource('/users', UserController::class);
Route::patch('update-password/{id}', [UserController::class, "updatePassword"]);

//autentikált útvonal, user is
Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('/auth/users', [UserController::class, 'show']);
        Route::patch('/auth/users', [UserController::class, 'update']);
        // hány kölcsönzése volt idáig
        Route::get('/lendings-count', [LendingController::class, 'lendingCount']);
        // hány aktív
        Route::get('/active-lending-count', [LendingController::class, 'activeLendingCount']);
        // hány könyvet kölcsönzött idáig
        Route::get('/lendings-books-count', [LendingController::class, 'lendingBooksCount']);
        // kikölcsönzött könyvek adatai
        Route::get('/lendings-books-data', [LendingController::class, 'lendingsBooksData']);
        // könyvenként csoportosítsd, csak azokat, amik max 1 pélányban vannak
        Route::get('/lendings-books-maxone', [LendingController::class, 'lendingsBooksYear']);
        Route::get('/lendings-book-hard-covered', [LendingController::class, 'lendingsHardCovered']);
        Route::get('/lendings-copies', [LendingController::class, "lendingsWithCopies"]);
        Route::get('/userlend', [UserController::class, "userLendings"]);

        // Kijelentkezés útvonal
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    });

//admin
Route::middleware(['auth:sanctum',Admin::class])
->group(function () {
    Route::apiResource('/admin/users', UserController::class);
    Route::get('/admin/specific-date', [LendingController::class, "dateSpecific"]);
    Route::get('/admin/specific-copy/{copy_id}', [LendingController::class, "copySpecific"]);
});


//librarian
Route::middleware(['auth:sanctum',Librarian::class])
->group(function () {
    // útvonalak
    Route::get('books-copies', [BookController::class, "booksWithCopies"]);
});


//warehouseman
Route::middleware(['auth:sanctum',Warehouseman::class])
->group(function () {
    // útvonalak
});

Route::get('books-copies', [BookController::class, "booksWithCopies"]);
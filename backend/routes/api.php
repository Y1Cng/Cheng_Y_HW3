<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

// Author resource routes
Route::get('/authors',            [AuthorController::class, 'index']);
Route::post('/authors',           [AuthorController::class, 'store']);
Route::get('/authors/{author}',   [AuthorController::class, 'show']);
Route::patch('/authors/{author}', [AuthorController::class, 'update']);
Route::delete('/authors/{author}',[AuthorController::class, 'destroy']);

// Book resource routes
Route::get('/books',          [BookController::class, 'index']);
Route::post('/books',         [BookController::class, 'store']);
Route::get('/books/{book}',   [BookController::class, 'show']);
Route::patch('/books/{book}', [BookController::class, 'update']);
Route::delete('/books/{book}',[BookController::class, 'destroy']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

// GET list endpoints only for now
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/books',   [BookController::class,  'index']);

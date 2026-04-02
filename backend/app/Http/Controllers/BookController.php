<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Return a list of all books with their author.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Book::with('author')->orderBy('title')->get();
    }
}

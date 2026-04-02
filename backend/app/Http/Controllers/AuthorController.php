<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Return a list of all authors with book counts.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Author::withCount('books')->orderBy('name')->get();
    }
}

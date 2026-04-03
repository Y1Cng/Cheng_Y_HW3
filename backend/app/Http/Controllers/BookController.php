<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Return a list of books with optional filters.
     *
     * Assignment requires at least 3 filter params:
     *   ?search=    - partial match on title
     *   ?author_id= - filter by exact author ID
     *   ?min_price= - filter books at or above this price
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $search   = $request->get('search', '');
        $authorId = $request->get('author_id', null);
        $minPrice = $request->get('min_price', null);

        $query = Book::query();

        if (!empty($search)) {
            $query->where('title', 'LIKE', '%' . $search . '%');
        }

        if ($authorId !== null) {
            $query->where('author_id', '=', $authorId);
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        $query->with('author')->orderBy('title');

        return $query->get();
    }

    /**
     * Return a single book with its author.
     *
     * @param Book $book
     * @return Book
     */
    public function show(Book $book)
    {
        $book->load('author');
        return $book;
    }

    /**
     * Store a new book.
     *
     * @param Request $request
     * @return Book
     */
    public function store(Request $request)
    {
        return Book::create($request->all());
    }

    /**
     * Update an existing book.
     *
     * @param Request $request
     * @param Book $book
     * @return Book
     */
    public function update(Request $request, Book $book)
    {
        $book->update($request->all());
        return $book;
    }

    /**
     * Delete a book.
     *
     * @param Book $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}

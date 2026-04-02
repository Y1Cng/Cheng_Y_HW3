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

        // filter 2: exact author match
        if ($authorId !== null) {
            $query->where('author_id', '=', $authorId);
        }

        // filter 3: minimum price
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        $query->with('author')->orderBy('title');

        return $query->get();
    }
}

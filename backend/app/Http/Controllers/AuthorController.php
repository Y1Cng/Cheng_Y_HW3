<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Return a list of authors with optional search and email filters.
     *
     * Filters:
     *   ?search=  - partial match on name or bio
     *   ?email=   - partial match on email address
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $email  = $request->get('email', '');

        $query = Author::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('bio',  'LIKE', '%' . $search . '%');
            });
        }

        if (!empty($email)) {
            $query->where('email', 'LIKE', '%' . $email . '%');
        }

        $query->withCount('books')->orderBy('name');

        return $query->get();
    }

    /**
     * Return a single author with their books.
     *
     * @param Author $author
     * @return Author
     */
    public function show(Author $author)
    {
        $author->load('books');
        return $author;
    }

    /**
     * Store a new author.
     *
     * @param Request $request
     * @return Author
     */
    public function store(Request $request)
    {
        return Author::create($request->all());
    }

    /**
     * Update an existing author.
     *
     * @param Request $request
     * @param Author $author
     * @return Author
     */
    public function update(Request $request, Author $author)
    {
        $author->update($request->all());
        return $author;
    }

    /**
     * Delete an author.
     *
     * @param Author $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->noContent();
    }
}

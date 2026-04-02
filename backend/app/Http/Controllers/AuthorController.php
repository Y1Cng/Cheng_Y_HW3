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
            // search name OR bio with a single query param
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
}

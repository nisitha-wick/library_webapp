<?php

namespace App\Http\Controllers;

use App\Models\Book;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        return response()->json($books);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $books = Book::where('id', '=', $query)
            ->orWhere('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('genre', 'like', "%$query%")
            ->orWhere('price', '=', $query)
            ->select('id', 'title', 'description', 'genre', 'price')
            ->paginate(10);

        return response()->json($books);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(10);
        $user = Auth::user();
        $borrowedBooks = Borrowing::where('user_id', $user->id)->pluck('book_id');

        return response()->json([
            'books' => $books->items(),
            'borrowedBooks' => $borrowedBooks,
            'data' => $books->items(),
            'current_page' => $books->currentPage(),
            'last_page' => $books->lastPage(),
        ]);
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

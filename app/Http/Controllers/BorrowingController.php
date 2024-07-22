<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BorrowingController extends Controller
{
    public function borrow(Request $request, Book $book): JsonResponse
    {
        $user = Auth::user();

        $existingBorrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->exists();

        if ($existingBorrowing) {
            return response()->json(['message' => 'You have already borrowed this book.'], 400);
        }

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        return response()->json(['message' => 'Book borrowed successfully.'], 200);
    }

    public function returnBook(Request $request, Book $book): JsonResponse
    {
        $user = Auth::user();
        $borrowing = Borrowing::where('user_id', $user->id)->where('book_id', $book->id)->first();

        if (!$borrowing) {
            return response()->json(['message' => 'You have not borrowed this book.'], 400);
        }

        $borrowing->delete();

        return response()->json(['message' => 'Book returned successfully.'], 200);
    }

    public function getBorrowedBooks(): JsonResponse
    {
        $user = Auth::user();
        $borrowedBooks = Borrowing::where('user_id', $user->id)->pluck('book_id');
        $books = Book::whereIn('id', $borrowedBooks)->get();

        return response()->json($books);
    }
}

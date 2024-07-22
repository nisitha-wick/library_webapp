<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    public function borrow(Request $request, $bookId)
    {
        $user = $request->user();

        $existingBorrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->first();

        if ($existingBorrowing) {
            return response()->json(['message' => 'You have already borrowed this book.'], 400);
        }

        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $bookId,
        ]);

        return response()->json(['message' => 'Book borrowed successfully.']);
    }

    public function returnBook(Request $request, $bookId)
    {
        $user = $request->user();

        $borrowing = Borrowing::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->first();

        if (!$borrowing) {
            return response()->json(['message' => 'You have not borrowed this book.'], 400);
        }

        $borrowing->delete();
        return response()->json(['message' => 'Book returned successfully.']);
    }
}

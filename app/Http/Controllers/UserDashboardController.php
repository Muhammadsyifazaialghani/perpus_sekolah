<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::paginate(10);
        $user = auth()->user();
        return view('user.dashboard', compact('books', 'user'));
    }

    public function publicIndex(Request $request)
    {
        $books = Book::paginate(10);
        return view('user.dashboard', compact('books'));
    }

    public function publicSearch(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->paginate(10);
        return view('user.dashboard', compact('books'));
    }

    public function publicShowBook($id)
    {
        $book = Book::findOrFail($id);
        return view('user.book_detail', compact('book'));
    }

    public function searchBooks(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->paginate(10);
        return view('user.dashboard', compact('books'));
    }

    public function showBook($id)
    {
        $book = Book::findOrFail($id);
        return view('user.book_detail', compact('book'));
    }

    public function borrowForm($id)
    {
        $book = Book::findOrFail($id);
        if (!$book->available) {
            return redirect()->route('dashboard')->with('error', 'Buku tidak tersedia');
        }
        return view('user.borrow_form', compact('book'));
    }

    public function confirmBorrow(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        if (!$book->available) {
            return redirect()->route('dashboard')->with('error', 'Buku tidak tersedia');
        }

        $borrowing = Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addWeeks(2),
            'status' => 'pending',
        ]);

        // Mark book as unavailable
        $book->available = false;
        $book->save();

        return redirect()->route('dashboard')->with('success', 'Peminjaman berhasil dikonfirmasi');
    }
}

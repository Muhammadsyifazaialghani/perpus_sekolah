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
        $books = Book::paginate(12);
        $user = auth()->user();

        // Count borrowings with fines for the logged-in user
        $fineCount = \App\Models\Borrowing::where('user_id', $user->id)
            ->where('fine_amount', '>', 0)
            ->count();

        return view('user.dashboard', compact('books', 'user', 'fineCount'));
    }

    public function showBooksByCategory($categoryId)
    {
        $books = Book::where('category_id', $categoryId)->paginate(12);
        $category = \App\Models\Category::findOrFail($categoryId);
        $user = auth()->user();

        // Count borrowings with fines for the logged-in user
        $fineCount = \App\Models\Borrowing::where('user_id', $user->id)
            ->where('fine_amount', '>', 0)
            ->count();

        return view('user.dashboard', compact('books', 'category', 'user', 'fineCount'));
    }

    public function publicIndex(Request $request)
    {
        $books = Book::paginate(12);
        return view('user.dashboard', compact('books'));
    }

    public function publicSearch(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'like', "%{$query}%")
            ->orWhere('author', 'like', "%{$query}%")
            ->paginate(12);
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
            ->paginate(12);
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

        // Check if user is admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Admin tidak diperbolehkan meminjam buku');
        }

        return view('user.borrow_form', compact('book'));
    }

    public function confirmBorrow(Request $request, $id)
    {
        // --- Kode di bawah ini sekarang akan dijalankan ---

        // Check if user is admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Admin tidak diperbolehkan meminjam buku');
        }

        // 1. Validasi input dari form, termasuk class_major
        $request->validate([
            'class_major' => 'required|string|max:255',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
        ]);

        $book = Book::findOrFail($id);
        if (!$book->available) {
            return redirect()->route('dashboard')->with('error', 'Buku tidak tersedia');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user(); // Ambil user yang sedang login
        $activeBorrowingsCount = Borrowing::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeBorrowingsCount >= 3) {
            return redirect()->route('dashboard')->with('error', 'Batas maksimal peminjaman adalah 3 buku.');
        }

        // 2. SIMPAN DATA JURUSAN KE PROFIL USER
        $user->update([
            'class_major' => $request->input('class_major'),
        ]);

        // 3. Lanjutkan proses peminjaman
        $borrowing = Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => $request->borrowed_at,
            'due_at' => $request->due_at,
            'status' => 'pending',
        ]);

        $book->available = false;
        $book->save();

        return redirect()->route('dashboard')->with('success', 'Peminjaman berhasil dikonfirmasi');
    }

    public function borrowHistory()
    {
        $user = auth()->user();
        $borrowings = Borrowing::with('book')
            ->where('user_id', $user->id)
            ->orderBy('borrowed_at', 'desc')
            ->paginate(10);

        return view('user.borrow_history', compact('borrowings'));
    }

    public function listCategories()
    {
        $categories = \App\Models\Category::paginate(10);
        return view('user.categories', compact('categories'));
    }

    public function returnBookForm()
    {
        $user = auth()->user();
        $borrowings = \App\Models\Borrowing::with('book')
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved', 'borrowed'])
            ->get();

        return view('user.return_book', compact('borrowings'));
    }

    public function processReturn(Request $request)
    {
        $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
            'return_date' => 'required|date',
            'book_condition' => 'required|in:baik,rusak,hilang',
            'notes' => 'nullable|string|max:500'
        ]);

        $borrowing = \App\Models\Borrowing::findOrFail($request->borrowing_id);

        // Pastikan ini adalah peminjaman milik user yang login
        if ($borrowing->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk pengembalian ini.');
        }

        // Gunakan waktu real time saat ini untuk returned_at
        $currentDateTime = now();

        // Update status pengembalian
        $borrowing->returned_at = $currentDateTime;
        $borrowing->status = 'returned';
        $borrowing->book_condition = $request->book_condition;
        $borrowing->return_notes = $request->notes;

        // Hitung dan simpan denda jika terlambat menggunakan Carbon untuk presisi waktu
        $dueDate = \Carbon\Carbon::parse($borrowing->due_at);
        $returnDateTime = $currentDateTime;

        if ($returnDateTime->gt($dueDate)) {
            $daysLate = $dueDate->diffInDays($returnDateTime);
            $borrowing->fine_amount = $daysLate * 2000; // Rp 2.000 per hari
        } else {
            $borrowing->fine_amount = 0;
        }

        $borrowing->save();

        // Update ketersediaan buku
        $book = $borrowing->book;
        if ($request->book_condition !== 'hilang') {
            $book->available = true;
        }
        $book->save();

        if ($borrowing->fine_amount > 0) {
            return redirect()->route('dashboard')->with('success', 'Buku berhasil dikembalikan pada ' . $currentDateTime->format('d M Y H:i:s') . '. Denda keterlambatan: Rp ' . number_format($borrowing->fine_amount, 0, ',', '.'));
        }

        return redirect()->route('dashboard')->with('success', 'Buku berhasil dikembalikan pada ' . $currentDateTime->format('d M Y H:i:s') . ' tepat waktu!');
    }

    public function borrowingReport()
    {
        // Redirect ke halaman admin borrowing report
        return redirect('/admin/borrowings/report');
    }

    public function welcome(Request $request)
    {
        $featuredBooks = Book::withCount('borrowings')
            ->orderBy('borrowings_count', 'desc')
            ->take(3)
            ->get();
        return view('welcome', compact('featuredBooks'));
    }
}

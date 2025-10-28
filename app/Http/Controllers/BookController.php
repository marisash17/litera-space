<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query dasar
        $books = Book::query();

        if ($search) {
            $books->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
        }

        $books = $books->get();

        return view('User.books', compact('books', 'search'));
    }
}

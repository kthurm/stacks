<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;

class BookController
{
    public function index()
    {
        // Fetch books from the database
        $books = Book::latest()->paginate(30);

        // Return the books to Inertia
        return Inertia::render('Books/Index', [
            'books' => $books
        ]);
    }
    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book' => $book
        ]);
    }


}

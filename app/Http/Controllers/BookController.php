<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'created_at');

        $booksQuery = Book::where('isFeatured', true);

        if ($sort == 'title') {
            $booksQuery->orderBy('title');
        } elseif ($sort == 'author') {
            $booksQuery->orderBy('author');
        } elseif ($sort == 'published_year') {
            $booksQuery->orderBy('published_year');
        } else {
            $booksQuery->orderBy('created_at', 'desc');
        }

        $books = $booksQuery->get();

        return Inertia::render('Books/Index', [
            'books' => [
                'data' => $books,
            ],
            'currentSort' => $sort,
        ]);
    }


    public function dashboard()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(40);


        return Inertia::render('Dashboard', [
            'books' => $books
        ]);

    }

    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book' => $book,
        ]);
    }

    public function create()
    {
        return Inertia::render('Books/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'published_year' => ['required', 'integer'],
            'publisher' => ['nullable', 'string'],
            'isbn' => ['nullable', 'string'],
            'page_count' => ['nullable', 'integer'],
            'summary' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'url'],
            'stock' => ['nullable', 'integer'],
            'available' => ['nullable', 'integer'],
        ]);


        Book::create($validated);


        return redirect(route('dashboard'));
    }

    private function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public function borrow(Request $request, $bookId)
    {

        $user = Auth::user();


        $book = Book::findOrFail($bookId);

        if ($book->available && $book->stock > 0) {

            $user->books()->attach($bookId, ['isCheckedOut' => true]);


            $book->isCheckedOut = true;
            $book->available = false;
            $book->stock -= 1;
            $book->save();


            return Inertia::location(route('books.show', $bookId));
        }


        return redirect()->back()->with('error', 'The book is not available for borrowing.');
    }

    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', [
            'book' => $book
        ]);
    }

    public function checkedOutBooks(Request $request)
    {
        $user = Auth::user();


        dd('hello');

        $checkedOutBooks = $user->books()->wherePivot('isCheckedOut', true)->get();

        return Inertia::render('Books/CheckedOut', [
            'checkedOutBooks' => $checkedOutBooks,
        ]);
    }


    public function returnBook(Request $request, $bookId)
    {
        $user = Auth::user();

        if ($user->role !== 'librarian') {
            return redirect()->back()->with('error', 'You are not authorized to return books.');
        }

        $book = Book::findOrFail($bookId);

        if ($user->books()->wherePivot('book_id', $bookId)->exists()) {
            $user->books()->detach($bookId);

            $book->isCheckedOut = false;
            $book->available = true;
            $book->stock += 1;
            $book->save();

            return Inertia::location(route('dashboard'))->with('success', 'Book returned successfully.');
        }

        return redirect()->back()->with('error', 'Book was not checked out.');
    }


    public function update(Request $request, Book $book)
    {

        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'author' => ['required', 'max:255'],
            'published_year' => ['required', 'integer'],
            'publisher' => ['nullable', 'string'],
            'isbn' => ['nullable', 'string'],
            'page_count' => ['nullable', 'integer'],
            'summary' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string', 'url'],
        ]);


        $book->update($validated);


        return redirect()->route('dashboard')->with('success', 'Book updated successfully.');
    }


    public function destroy(Book $book)
    {
        $book->delete();

    }
}

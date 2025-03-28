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

        if ($sort == 'title') {
            $books = Book::orderBy('title')->paginate(30);
        } elseif ($sort == 'author') {
            $books = Book::orderBy('author')->paginate(30);
        } elseif ($sort == 'published_year') {
            $books = Book::orderBy('published_year')->paginate(30);
        } elseif ($sort == 'created_at') {
            $books = Book::orderBy('created_at', 'desc')->paginate(30);
        } else {
            $books = Book::orderBy('created_at', 'desc')->paginate(30);
        }

        return Inertia::render('Books/Index', [
            'books' => $books,
            'currentSort' => $sort,
        ]);
    }

    public function dashboard()
    {
        $books = Book::paginate(50);

        return Inertia::render('Dashboard', [
            'books' => $books,
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

        // Debugging point
        dd('hello');  // Check if this is being executed

        $checkedOutBooks = $user->books()->wherePivot('isCheckedOut', true)->get();

        return Inertia::render('Books/Checkedout', [
            'checkedOutBooks' => $checkedOutBooks,
        ]);
    }



    public function returnBook(Request $request, $bookId)
    {
        $user = Auth::user();

        $book = Book::findOrFail($bookId);

        // Detach the book from the user's checked-out list
        $user->books()->detach($bookId);

        // Update the book's stock and availability
        $book->isCheckedOut = false;
        $book->available = true;
        $book->stock += 1;
        $book->save();

        return redirect()->route('books')->with('success', 'Book returned successfully.');
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

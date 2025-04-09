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
        $search = $request->query('search');

        $booksQuery = Book::where('isFeatured', true);

        // Sorting logic
        if ($sort == 'title') {
            $booksQuery->orderBy('title');
        } elseif ($sort == 'author') {
            $booksQuery->orderBy('author');
        } elseif ($sort == 'published_year') {
            $booksQuery->orderBy('published_year');
        } else {
            $booksQuery->orderBy('created_at', 'desc');
        }

        // Searching logic
        if ($search) {
            $booksQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $booksQuery->get();


        return Inertia::render('Books/Index', [
            'books' => [
                'data' => $books,
                'sortOption' => $sort,
                'filters' => [
                    'search' => $search,
                    'sort' => $sort
                ],
            ],
            'noResults' => $books->isEmpty(),
        ]);
    }


    public function dashboard()
    {
        $books = Book::orderBy('created_at', 'desc')->paginate(40);


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
            'title' => ['required', 'min:5', 'max:255'],
            'author' => ['required', 'max:255'],
            'published_year' => ['required', 'integer'],
            'publisher' => ['required', 'string'],
            'isbn' => ['required', 'string'],
            'page_count' => ['required', 'integer'],
            'summary' => ['required', 'string'],
            'category' => ['required', 'string'],
            'cover_image' => ['required', 'string', 'url'],
            'stock' => ['required', 'integer'],
            'available' => ['integer'],
            'isFeatured' => ['boolean']
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
        $borrowedAt = now();
        $dueDate = now()->addDays(5);

        if ($book->available && $book->stock > 0) {
            $user->books()->attach($bookId, ['isCheckedOut' => true]);

            $book->isCheckedOut = true;
            $book->available = false;
            $book->stock -= 1;
            $book->borrowed_at = $borrowedAt;
            $book->due_date = $dueDate;
            $book->save();


            return Inertia::render('Books/Show', [
                'book' => $book,
                'user' => $user,

            ]);
        }

        return redirect()->back()->with('error', 'The book is not available for borrowing.');
    }


    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', [
            'book' => $book
        ]);
    }

    // public function checkedOutBooks(Request $request)
    // {
    //     $user = Auth::user();


    //     dd('hello');

    //     $checkedOutBooks = $user->books()->wherePivot('isCheckedOut', true)->get();

    //     return Inertia::render('Books/CheckedOut', [
    //         'checkedOutBooks' => $checkedOutBooks,
    //     ]);
    // }


    public function returnBook(Request $request, $bookId)
    {
        $user = Auth::user();
        $book = Book::findOrFail($bookId);

        // Check if the user is a librarian
        if ($user->role !== 'librarian') {
            if (!$user->books()->wherePivot('book_id', $bookId)->exists()) {
                return redirect()->back()->with('error', 'You cannot return this book.');
            }
        }

        $user->books()->detach($bookId);

        $book->isCheckedOut = false;
        $book->available = true;
        $book->stock += 1;
        $book->save();

        return redirect()->back()->with('success', 'Book returned successfully.');
    }


    public function update(Request $request, Book $book)
    {

        $validated = $request->validate([
            'title' => ['required', 'min:5' ,'max:255'],
            'author' => ['required', 'max:255'],
            'published_year' => ['required', 'integer'],
            'publisher' => ['required', 'string'],
            'isbn' => ['required', 'string'],
            'page_count' => ['required', 'integer'],
            'summary' => ['required', 'string'],
            'category' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'url'],
            'isFeatured' => ['nullable', 'boolean']
        ]);


        $book->update($validated);


        return redirect()->route('dashboard')->with('success', 'Book updated successfully.');
    }


    public function destroy(Book $book)
    {
        $book->delete();

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserBookController extends Controller
{

    public function index()
    {
        $books = Book::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id())
                  ->where('isCheckedOut', true);
        })->get();

        return Inertia::render('UserBooks/Index', [
            'books' => $books,
              'flash' => 'Your review has been submitted!',
        ]);
    }

    public function rate(Request $request, $bookId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $book = Book::findOrFail($bookId);

        if ($book->rating_count > 0) {
            $book->rating = (($book->rating * $book->rating_count) + $validated['rating']) / ($book->rating_count + 1);
            $book->rating_count += 1;
        } else {

            $book->rating = $validated['rating'];
            $book->rating_count = 1;
        }


        $book->save();

        return redirect()->route('userbooks.index')->with('flash', 'Rating updated successfully!');
    }


   public function review(Request $request, $bookId)
   {
       $validated = $request->validate([
           'review' => 'required|string|max:1000',
       ]);

       $book = Book::findOrFail($bookId);


       $book->review = $validated['review'];
       $book->save();


       return redirect()->route('userbooks.index')->with('flash', 'Review updated successfully!');
    }

}

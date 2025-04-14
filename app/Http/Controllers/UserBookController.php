<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserBookController extends Controller
{

    public function index()
    {
        $books = Auth::user()
        ->books()
        ->wherePivot('isCheckedOut', true)
        ->withPivot('review', 'rating', 'isCheckedOut', 'due_date', 'borrowed_at')
        ->get();

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
        $user = Auth::user();

        $user->books()->updateExistingPivot($bookId, [
            'rating' => $validated['rating'],
        ]);

        return redirect()->route('userbooks.index')->with('flash', 'Rating updated!');
    }

    public function review(Request $request, $bookId)
    {
        $validated = $request->validate([
            'review' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        $user->books()->updateExistingPivot($bookId, [
            'review' => $validated['review'],
        ]);
      

        return redirect()->route('userbooks.index')->with('flash', 'Review updated!');
    }
}

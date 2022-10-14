<?php


namespace App\Http\Controllers;
use App\Models\Authors;
use App\Models\Books;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isFalse;


class BooksController extends Controller
{
    public function main()
    {
        $books = Books::with('authors')->get();
        return view('main', compact('books'));
    }
    public function search(Request $request)
    {
        $search_key = $request->input('key');
        $books = Books::with('authors')->where('title', 'like', '%' . $search_key . '%')->get();
        return view('main', compact('books'))->with('result', $books->count());
    }
    public function delete(Request $request)
    {
        $book_id = $request->input('book_id');
        Books::with('books_authors')->find($book_id)->delete();
        return back();
    }
}

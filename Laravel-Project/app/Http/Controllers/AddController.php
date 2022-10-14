<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Books;
use App\Models\Books_Authors;
use Illuminate\Http\Request;

class AddController extends Controller
{

    public function main()
    {
        $authors = Authors::all();
        return view('add', compact('authors'));
    }

    public function add(Request $request)
    {
        $books = new Books;
        $books->title = $request->input('title');
        $books->price = $request->input('price');
        $this->validate($request, [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
            'authors' => 'required'
        ]);
        $books->save();
        $book_id = $books->id;
        foreach ($request->input('authors') as $author) {
            $books_authors = new Books_Authors;
            $books_authors->authors_id = $author;
            $books_authors->books_id = $book_id;
            $books_authors->save();
        }
        return redirect()->back()->with('message', 'Գիրքը հաջողությամբ ստեղծվել է');
    }
}

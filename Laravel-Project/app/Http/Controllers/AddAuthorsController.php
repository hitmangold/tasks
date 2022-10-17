<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Books;
use App\Models\Books_Authors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AddAuthorsController extends Controller
{
    public function main()
    {
        $books = Books::all();
        return view('add_authors', compact('books'));
    }

    public function add(Request $request)
    {
        $authors = new Authors;
        $authors->name = $request->input('name');
        $authors->surname = $request->input('surname');
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
        ]);
        $authors->save();
        $author_id = $authors->id;
        $books = $request->input('books');
        if (!is_null($books)) {
            foreach ($books as $book) {
                $books_authors = new Books_Authors;
                $books_authors->authors_id = $author_id;
                $books_authors->books_id = $book;
                $books_authors->save();
            }
        }
        return redirect()->back()->with('message', 'Հեղինակը հաջողությամբ ստեղծվել է');
    }
}

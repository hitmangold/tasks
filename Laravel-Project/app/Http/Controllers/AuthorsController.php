<?php

namespace App\Http\Controllers;
use App\Models\Authors;
use App\Models\Books;
use App\Models\Books_Authors;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function main()
    {
        $authors = Authors::with('books')->get();
        return view('authors',compact('authors'));
    }
    public function search(Request $request)
    {
        $search_key = $request->input('key');
        $authors = Authors::with('books')->where('name', 'like', '%' . $search_key . '%')->orWhere('surname', 'like', '%' . $search_key . '%')->get();
        return view('authors', compact('authors'))->with('result', $authors->count());
    }
    public function delete(Request $request)
    {
        $author_id = $request->input('author_id');
        Authors::with('books_authors')->find($author_id)->delete();
        return back();
    }
    public function edit(Request $request)
    {
        $author_id = $request->input('edit_id');
        $author = Authors::with('books')->find($author_id);
        $books = Books::all();
        return view('add_authors', compact('books','author'));
    }
    public function update(Request $request)
    {
        $author_id = $request->input('edit_id');
        $author = Authors::with('books_authors')->find($author_id);
        $author->name = $request->input('name');
        $author->surname = $request->input('surname');
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
        ]);
        $books = $request->input('books');
        if ($books == null) {
            $books = [];
        }
        $booksAuthors_id = [];
        foreach ($author['books_authors'] as $author_books) {
            array_push($booksAuthors_id, $author_books['books_id']);
        }
        $deleted_repeat_one = array_diff($booksAuthors_id, $books);
        $deleted_repeat_two = array_diff($books, $booksAuthors_id);
        if(!empty($deleted_repeat_one)){
            foreach ($deleted_repeat_one as $id) {
                Books_Authors::where('authors_id', $author_id)->where('books_id', $id)->delete();
            }
        }
        if(!empty($deleted_repeat_two)){
            foreach ($deleted_repeat_two as $book) {
                $books_authors = new Books_Authors;
                $books_authors->authors_id = $author_id;
                $books_authors->books_id = $book;
                $books_authors->save();
            }
        }
        $author->save();
        return redirect('authors');
    }
}

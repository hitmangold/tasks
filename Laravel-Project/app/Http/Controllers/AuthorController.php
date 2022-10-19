<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('key')) {
            $search_key = $request->input('key');
            $authors = Author::with('Books')->where('name', 'like', '%' . $search_key . '%')->orWhere('surname', 'like', '%' . $search_key . '%')->get();
            return view('Author.authors', compact('authors'))->with('count', $authors->count());
        }
        $authors = Author::with('books')->get();
        return view('Author.authors', compact('authors'));
    }

    public function create()
    {
        $books = Book::all();
        return view('Author.add_authors', compact('books'));
    }

    public function store(Request $request)
    {
        $authors = new Author;
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
                $books_authors = new BookAuthor;
                $books_authors->author_id = $author_id;
                $books_authors->book_id = $book;
                $books_authors->save();
            }
        }
        return redirect()->back()->with('message', 'Հեղինակը հաջողությամբ ստեղծվել է');
    }

    public function show($id)
    {
        $author = Author::with('books')->find($id);
        $books = Book::all();
        return view('Author.add_authors', compact('books', 'author'))->with('show', 1);
    }

    public function edit($id)
    {
        $author = Author::with('books')->find($id);
        $books = Book::all();
        return view('Author.add_authors', compact('books', 'author'));
    }

    public function update(Request $request, $id)
    {
        $author_id = $id;
        $author = Author::with('BooksAuthors')->find($author_id);
        $author->fill(array('name' => $request->input('name'), 'surname' => $request->input('surname')));
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
        ]);
        $books = $request->input('books');
        if ($books == null) {
            $books = [];
        }
        $booksAuthors_id = [];
        foreach ($author->BooksAuthors as $author_books) {
            array_push($booksAuthors_id, $author_books['book_id']);
        }
        $deleted_repeat_one = array_diff($booksAuthors_id, $books);
        $deleted_repeat_two = array_diff($books, $booksAuthors_id);
        if (!empty($deleted_repeat_one)) {
            BookAuthor::where('author_id', $author_id)->whereIn('book_id', $deleted_repeat_one)->delete();
        }
        if (!empty($deleted_repeat_two)) {
            foreach ($deleted_repeat_two as $book) {
                $books_authors = new BookAuthor;
                $books_authors->fill(array('author_id' => $author_id, 'book_id' => $book));
                $books_authors->save();
            }
        }
        $author->save();
        return redirect('authors');
    }

    public function destroy($id)
    {
        $author_id = $id;
        $author = Author::find($author_id);
        if ($author) {
            $author->delete();
        }
        return back();
    }
}

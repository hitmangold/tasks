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
        $author = new Author;
        $author->name = $request->input('name');
        $author->surname = $request->input('surname');
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
        ]);
        $author->save();
        $author_id = $author->id;
        $books = $request->input('books');
        if (!is_null($books)) {
            foreach ($books as $book) {
                $BookAuthor = new BookAuthor;
                $BookAuthor->author_id = $author_id;
                $BookAuthor->book_id = $book;
                $BookAuthor->save();
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
        $BooksAuthorsId = [];
        foreach ($author->BooksAuthors as $author_books) {
            array_push($BooksAuthorsId, $author_books->book_id);
        }
        $DeletedRepeatOne = array_diff($BooksAuthorsId, $books);
        $DeletedRepeatTwo = array_diff($books, $BooksAuthorsId);
        if (!empty($DeletedRepeatOne)) {
            BookAuthor::where('author_id', $author_id)->whereIn('book_id', $DeletedRepeatOne)->delete();
        }
        if (!empty($DeletedRepeatTwo)) {
            foreach ($DeletedRepeatTwo as $book) {
                $BookAuthor = new BookAuthor;
                $BookAuthor->fill(array('author_id' => $author_id, 'book_id' => $book));
                $BookAuthor->save();
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

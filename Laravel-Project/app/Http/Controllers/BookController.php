<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('key')) {
            $search_key = $request->input('key');
            $books = Book::with('authors')->where('title', 'like', '%' . $search_key . '%')->get();
            return view('Book.main', compact('books'))->with('count', $books->count());
        }
        $books = Book::with('authors')->get();
        return view('Book.main', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('Book.add', compact('authors'));
    }

    public function store(Request $request)
    {
        $books = new Book;
        $books->fill(array('title' => $request->input('title'), 'price' => $request->input('price')));
        $this->validate($request, [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
            'authors' => 'required'
        ]);
        $books->save();
        $book_id = $books->id;
        foreach ($request->input('authors') as $author) {
            $books_authors = new BookAuthor;
            $books_authors->fill(array('author_id' => $author, 'book_id' => $book_id));
            $books_authors->save();
        }
        return redirect()->back()->with('message', 'Գիրքը հաջողությամբ ստեղծվել է');
    }

    public function show($id)
    {
        $books = Book::with('authors')->find($id);
        $authors = Author::all();
        return view('Book.add', compact('authors', 'books'))->with('show', 1);
    }

    public function edit($id)
    {
        $books = Book::with('authors')->find($id);
        $authors = Author::all();
        return view('Book.add', compact('authors', 'books'));
    }

    public function update(Request $request, $id)
    {
        $book_id = $id;
        $book = Book::with('BooksAuthors')->find($book_id);
        $book->title = $request->input('title');
        $book->price = $request->input('price');
        $this->validate($request, [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
            'authors' => 'required'
        ]);
        $author = $request->input('authors');
        $booksAuthors_id = [];
        foreach ($book->BooksAuthors as $author_books) {
            array_push($booksAuthors_id, $author_books['authors_id']);
        }
        $deleted_repeat_one = array_diff($booksAuthors_id, $author);
        $deleted_repeat_two = array_diff($author, $booksAuthors_id);
        if (!empty($deleted_repeat_one)) {
            BookAuthor::where('book_id', $book_id)->whereIn('author_id', $deleted_repeat_one)->delete();
        }
        if (!empty($deleted_repeat_two)) {
            foreach ($deleted_repeat_two as $author) {
                $books_authors = new BookAuthor;
                $books_authors->fill(array('author_id' => $author, 'book_id' => $book_id));
                $books_authors->save();
            }
        }
        $book->save();
        return redirect('/');
    }

    public function destroy($id)
    {
        $book_id = $id;
        $book = Book::find($book_id);
        if ($book) {
            $book->delete();
        }
        return back();
    }
}

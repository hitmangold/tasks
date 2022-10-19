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
        $book = new Book;
        $book->fill(array('title' => $request->input('title'), 'price' => $request->input('price')));
        $this->validate($request, [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
            'authors' => 'required'
        ]);
        $book->save();
        $book_id = $book->id;
        foreach ($request->input('authors') as $author) {
            $BookAuthor = new BookAuthor;
            $BookAuthor->fill(array('author_id' => $author, 'book_id' => $book_id));
            $BookAuthor->save();
        }
        return redirect()->back()->with('message', 'Գիրքը հաջողությամբ ստեղծվել է');
    }

    public function show($id)
    {
        $book = Book::with('authors')->find($id);
        $authors = Author::all();
        return view('Book.add', compact('authors', 'book'))->with('show', 1);
    }

    public function edit($id)
    {
        $book = Book::with('authors')->find($id);
        $authors = Author::all();
        return view('Book.add', compact('authors', 'book'));
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
        $authors = $request->input('authors');
        $BooksAuthorsId = [];
        foreach ($book->BooksAuthors as $author_books) {
            array_push($BooksAuthorsId, $author_books->author_id);
        }
        $DeletedRepeatOne = array_diff($BooksAuthorsId, $authors);
        $DeletedRepeatTwo = array_diff($authors, $BooksAuthorsId);
        if (!empty($DeletedRepeatOne)) {
            BookAuthor::where('book_id', $book_id)->whereIn('author_id', $DeletedRepeatOne)->delete();
        }
        if (!empty($DeletedRepeatTwo)) {
            foreach ($DeletedRepeatTwo as $author) {
                $BookAuthor = new BookAuthor;
                $BookAuthor->fill(array('author_id' => $author, 'book_id' => $book_id));
                $BookAuthor->save();
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

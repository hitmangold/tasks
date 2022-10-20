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
        $query = Book::with('authors');
        if ($request->input('search_title')) {
            $query = $query->where('title', 'like', '%' . $request->input('search_title') . '%');
        }
        $books = $query->paginate(3);
        return view('book.index', compact('books'))->with('count', $books->count());
    }

    public function create()
    {
        $authors = Author::all();
        return view('book.create', compact('authors'));
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
            $bookAuthor = new BookAuthor;
            $bookAuthor->fill(array('author_id' => $author, 'book_id' => $book_id));
            $bookAuthor->save();
        }
        return redirect()->route('books.create')->with('message', 'Գիրքը հաջողությամբ ստեղծվել է');
    }

    public function show($id)
    {
        $book = Book::with('authors')->find($id);
        $authors = Author::all();
        return view('book.show', compact('authors', 'book'))->with('show', 1);
    }

    public function edit($id)
    {
        $book = Book::with('authors')->find($id);
        $authors = Author::all();
        return view('book.edit', compact('authors', 'book'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::with('booksAuthors')->find($id);
        $book->title = $request->input('title');
        $book->price = $request->input('price');
        $this->validate($request, [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
            'authors' => 'required'
        ]);
        $authors = $request->input('authors');
        $booksAuthorsId = [];
        foreach ($book->booksAuthors as $author_books) {
            array_push($booksAuthorsId, $author_books->author_id);
        }
        $deletedRepeatOne = array_diff($booksAuthorsId, $authors);
        $deletedRepeatTwo = array_diff($authors, $booksAuthorsId);
        if (!empty($deletedRepeatOne)) {
            BookAuthor::where('book_id', $id)->whereIn('author_id', $deletedRepeatOne)->delete();
        }
        if (!empty($deletedRepeatTwo)) {
            foreach ($deletedRepeatTwo as $author) {
                $bookAuthor = new BookAuthor;
                $bookAuthor->fill(array('author_id' => $author, 'book_id' => $id));
                $bookAuthor->save();
            }
        }
        $book->save();
        return redirect()->route('books.index');
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if ($book) {
            $book->delete();
        }
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('web')->user();
        if ($user->role == 1) {
            $author = $user->author;
            $query = $author->books();
        } else if ($user->role == 2) {
            $query = Book::with('authors');
        }
       /* $query = Author::with('books')->find($author_id)->books();*/
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
        $user = auth('web')->user();
        $book = new Book;
        $book->fill(array('title' => $request->input('title'), 'price' => $request->input('price')));
        $validBook = [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
        ];
        if ($user->role == 2){
            $validBook['authors'] = "required";
        }
        $this->validate($request, $validBook);
        $book->save();
        $book_id = $book->id;
        if ($user->role == 1) {
            $bookAuthor = new BookAuthor;
            $bookAuthor->fill(array('author_id' => $user->id, 'book_id' => $book_id));
            $bookAuthor->save();
        } else {
            foreach ($request->input('authors') as $author) {
                $bookAuthor = new BookAuthor;
                $bookAuthor->fill(array('author_id' => $author, 'book_id' => $book_id));
                $bookAuthor->save();
            }
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
        $user = auth('web')->user();
        $book = Book::with('booksAuthors')->find($id);
        $book->title = $request->input('title');
        $book->price = $request->input('price');
        $validBook = [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
        ];
        if ($user->role == 2) {
            $validBook['authors'] = 'required';
        }
        $this->validate($request, $validBook);
        if ($user->role == 2) {
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

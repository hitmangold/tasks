<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::with('Books');
        if ($request->input('search_name')) {
            $query = $query->where('name', 'like', '%' . $request->input('search_name') . '%');
        }
        if ($request->input('search_surname')) {
            $query = $query->where('surname', 'like', '%' . $request->input('search_surname') . '%');
        }
        $authors = $query->paginate(3);
        return view('author.index', compact('authors'));
    }

    public function create()
    {
        $books = Book::all();
        return view('author.create', compact('books'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $userCreate = [
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'password' => app('hash')->make($request->input('password'))
        ];
        if ($request->input('role') == 'customer') {
            $userCreate['role'] = User::ROLE_CUSTOMER;
        } elseif ($request->input('role') == 'author') {
            $userCreate['role'] = User::ROLE_AUTHOR;
        }
        $user = User::create($userCreate);
        if ($user) {
            $author = new Author;
            $author->fill(['name' => $request->input('name'), 'surname' => $request->input('surname'), 'user_id' => $user->id]);
            $author->save();
            $author_id = $author->id;
            $books = $request->input('books');
            if (!is_null($books)) {
                foreach ($books as $book) {
                    $bookAuthor = new BookAuthor;
                    $bookAuthor->author_id = $author_id;
                    $bookAuthor->book_id = $book;
                    $bookAuthor->save();
                }
            }
            return redirect()->route('authors.create')->with('message', 'Հեղինակը հաջողությամբ ստեղծվել է');
        }
        return redirect()->route('authors.create');
    }

    public function show($id)
    {
        $author = Author::with('books')->find($id);
        $books = Book::all();
        return view('author.show', compact('books', 'author'))->with('show', 1);
    }

    public function edit($id)
    {
        $author = Author::with('books')->find($id);
        $books = Book::all();
        return view('author.edit', compact('books', 'author'));
    }

    public function update(Request $request, $id)
    {
        $author = Author::with('booksAuthors')->find($id);
        $user = $author->user;
        $user->fill(['name' => $request->input('name'), 'surname' => $request->input('surname')]);
        $author->fill(['name' => $request->input('name'), 'surname' => $request->input('surname')]);
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
        ]);
        $books = $request->input('books');
        if ($books == null) {
            $books = [];
        }
        $booksAuthorsId = [];
        foreach ($author->booksAuthors as $author_books) {
            array_push($booksAuthorsId, $author_books->book_id);
        }
        $deletedRepeatOne = array_diff($booksAuthorsId, $books);
        $deletedRepeatTwo = array_diff($books, $booksAuthorsId);
        if (!empty($deletedRepeatOne)) {
            BookAuthor::where('author_id', $id)->whereIn('book_id', $deletedRepeatOne)->delete();
        }
        if (!empty($deletedRepeatTwo)) {
            foreach ($deletedRepeatTwo as $book) {
                $bookAuthor = new BookAuthor;
                $bookAuthor->fill(['author_id' => $id, 'book_id' => $book]);
                $bookAuthor->save();
            }
        }
        $author->save();
        $user->save();
        return redirect()->route('authors.index');
    }

    public function destroy($id)
    {
        $author = Author::find($id);
        $user = User::find($author->id);
        if ($author) {
            $author->delete();
            $user->delete();
        }
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\User;
use App\Services\AuthorService;
use App\Services\BookService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function index(Request $request, AuthorService $authorService)
    {
        $authors = $authorService->index($request->input('search_name'), $request->input('search_surname'));
        return view('author.index', compact('authors'));
    }

    public function create()
    {
        $books = Book::all();
        return view('author.create', compact('books'));
    }

    public function store(StoreAuthorRequest $request, AuthorService $authorService)
    {
        $route = $authorService->addAuthor(
            $request->name,
            $request->surname,
            $request->email,
            $request->password,
            $request->role,
            $request->books
        );
        return $route;
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

    public function update(UpdateAuthorRequest $request, AuthorService $authorService, $id)
    {
        $authorService->update($request->name, $request->surname, $request->books, $id);
        return redirect()->route('authors.index');
    }

    public function destroy(AuthorService $authorService, $id)
    {
        $authorService->delete($id);
        return back();
    }
}

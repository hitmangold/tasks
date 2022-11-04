<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('book', ['only' => ['show', 'edit', 'destroy', 'update']]);
    }

    public function index(Request $request, BookService $bookService)
    {
        $view = $bookService->getPaginatedBooks($request->input('search_title'));
        return $view;
    }

    public function create()
    {
        $users = User::where('role', User::ROLE_AUTHOR)->get();
        return view('book.create', compact('users'));
    }

    public function store(StoreBookRequest $request, BookService $bookService)
    {
        $bookService->addBook($request->title,
            $request->price,
            $request->qty,
            $request->authors
        );
        return redirect()->route('books.create')->with('message', 'Գիրքը հաջողությամբ ստեղծվել է');
    }

    public function show(BookService $bookService, $id)
    {
        $data = $bookService->show($id);
        return view('book.show', compact('data'))->with('show', 1);
    }

    public function edit(BookService $bookService, $id)
    {
        $data = $bookService->edit($id);
        return view('book.edit', compact('data'));
    }

    public function update(UpdateBookRequest $request, BookService $bookService, $id)
    {
        $bookService->update($request->title, $request->price, $request->authors, $id);
        return redirect()->route('books.index');
    }

    public function destroy(BookService $bookService, $id)
    {
        $bookService->delete($id);
        return back();
    }
}

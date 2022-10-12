<?php


namespace App\Http\Controllers;
use App\Models\Authors;
use App\Models\Books;
use Illuminate\Http\Request;


class BooksController extends Controller
{
    public function main()
    {
        $books = Books::with('authors')->get();
        return view('main', compact('books'));
    }
}

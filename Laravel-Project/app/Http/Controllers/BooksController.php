<?php


namespace App\Http\Controllers;
use App\Models\Books;
use Illuminate\Http\Request;


class BooksController extends Controller
{
    public function main()
    {
        $books = Books::all();
        return view('main',compact('books'));
    }
}

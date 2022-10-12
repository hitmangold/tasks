<?php

namespace App\Http\Controllers;
use App\Models\Authors;
use App\Models\Books_Authors;
use Illuminate\Http\Request;
use DB;

class AuthorsController extends Controller
{
    public function main()
    {
        $authors = Authors::with('books')->get();
        return view('authors',compact('authors'));
    }
}

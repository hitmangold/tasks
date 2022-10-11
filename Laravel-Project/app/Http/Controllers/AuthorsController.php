<?php

namespace App\Http\Controllers;
use App\Models\Authors;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function main()
    {
        $authors = Authors::all();
        return view('authors',compact('authors'));
    }
}

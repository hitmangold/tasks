<?php

namespace App\Http\Controllers;
use App\Models\Authors;
use App\Models\Books;
use App\Models\Books_Authors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;

class AuthorsController extends Controller
{
    public function main()
    {
        $authors = Authors::with('books')->get();
        return view('authors',compact('authors'));
    }
    public function search(Request $request)
    {
        $search_key = $request->input('key');
        $authors = Authors::with('books')->where('name', 'like', '%' . $search_key . '%')->orWhere('surname', 'like', '%' . $search_key . '%')->get();
        return view('authors', compact('authors'))->with('result', $authors->count());
    }
    public function delete(Request $request)
    {
        $author_id = $request->input('author_id');
        Authors::with('books_authors')->find($author_id)->delete();
        return back();
    }
    public function edit(Request $request)
    {
        $author_id = $request->input('edit_id');
        $author = Authors::with('books')->find($author_id);
        $books = Books::all();
        return view('add_authors', compact('books','author'));
    }
    public function update(Request $request)
    {
        $author_id = $request->input('edit_id');
        $author = Authors::with('books')->find($author_id);
        $author->name = $request->input('name');
        $author->surname = $request->input('surname');
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
        ]);
        /*$books = $request->input('books');*/
        /*foreach ($author->books_authors as $author_books) {
            dd($author_books);die;
            $check = 0;
            $count = 0;
            foreach($books as $book) {
                $count++;
                if($author_books['id'] == $book){
                    $check = 1;
                    unset($books[$count]);
                }
            }
            if($check == 0){
                Books_Authors::find($author_books['id'])->delete();
            }
        }*/
        $author->save();
        return redirect('authors');
    }
}

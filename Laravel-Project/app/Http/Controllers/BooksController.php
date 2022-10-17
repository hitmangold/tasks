<?php


namespace App\Http\Controllers;
use App\Models\Authors;
use App\Models\Books;
use App\Models\Books_Authors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isFalse;


class BooksController extends Controller
{
    public function main()
    {
        $books = Books::with('authors')->get();
        return view('main', compact('books'));
    }
    public function search(Request $request)
    {
        $search_key = $request->input('key');
        $books = Books::with('authors')->where('title', 'like', '%' . $search_key . '%')->get();
        return view('main', compact('books'))->with('result', $books->count());
    }
    public function delete(Request $request)
    {
        $book_id = $request->input('book_id');
        Books::with('books_authors')->find($book_id)->delete();
        return back();
    }
    public function edit(Request $request)
    {
        $book_id = $request->input('edit_id');
        $books = Books::with('authors')->find($book_id);
        $authors = Authors::all();
        return view('add', compact('authors','books'));
    }
    public function update(Request $request)
    {
        $book_id = $request->input('edit_id');
        $book = Books::with('books_authors')->find($book_id);
        $book->title = $request->input('title');
        $book->price = $request->input('price');
        $this->validate($request, [
            'title' => 'required|min:8',
            'price' => 'required|numeric',
            'authors' => 'required'
        ]);
         $author = $request->input('authors');
         $booksAuthors_id = [];
         foreach ($book['books_authors'] as $author_books) {
             array_push($booksAuthors_id, $author_books['authors_id']);
         }
         $deleted_repeat_one = array_diff($booksAuthors_id, $author);
         $deleted_repeat_two = array_diff($author, $booksAuthors_id);
         if(!empty($deleted_repeat_one)){
             foreach ($deleted_repeat_one as $id) {
                 Books_Authors::where('books_id', $book_id)->where('authors_id', $id)->delete();
             }
         }
         if(!empty($deleted_repeat_two)){
             foreach ($deleted_repeat_two as $author) {
                 $books_authors = new Books_Authors;
                 $books_authors->authors_id = $author;
                 $books_authors->books_id = $book_id;
                 $books_authors->save();
             }
         }
        $book->save();
        return redirect('/');
    }
}

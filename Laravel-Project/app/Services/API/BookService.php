<?php


namespace App\Services\API;


use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BookService
{
    public function getBooks()
    {
        $user = auth('sanctum')->user();
        if ($user->role == User::ROLE_AUTHOR) {
            $author = $user->author;
            $query = $author->books;
        } elseif ($user->role == User::ROLE_ADMIN || $user->role == User::ROLE_CUSTOMER) {
            $query = Book::with('authors')->get();
        }
        $data = [
            'status' => true,
            'message' => 'Books Information',
            'books' => []
        ];
        foreach ($query as $book) {
            $data['books'][$book->id]['title'] = $book->title;
            $data['books'][$book->id]['price'] = $book->price;
            $data['books'][$book->id]['qty'] = $book->qty;
            foreach ($book->authors as $author) {
                $data['books'][$book->id]['authors'] = [
                    'name' => $author->name,
                    'surname' => $author->surname,
                ];
            }
        }
        return response()->json($data, 200);
    }
}

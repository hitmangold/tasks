<?php


namespace App\Services;


use App\Models\Author;
use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuthorService
{
    public function index(?string $search_name, ?string $search_surname)
    {
        $query = Author::with('Books');
        if ($search_name) {
            $query = $query->where('name', 'like', '%' . $search_name . '%');
        }
        if ($search_surname) {
            $query = $query->where('surname', 'like', '%' . $search_surname . '%');
        }
        return $query->paginate(3);
    }
    public function addAuthor(
        string $name,
        string $surname,
        string $email,
        string $password,
        string $role,
        array $books
    )
    {
        $route = redirect()->route('authors.create');
        $userCreate = [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => app('hash')->make($password)
        ];
        if ($role == 'customer') {
            $userCreate['role'] = User::ROLE_CUSTOMER;
        } elseif ($role == 'author') {
            $userCreate['role'] = User::ROLE_AUTHOR;
        }
        $user = User::create($userCreate);
        if ($user) {
            $author = new Author;
            $author->fill(['name' => $name, 'surname' => $surname, 'user_id' => $user->id]);
            $author->save();
            $author_id = $author->id;
            if (!is_null($books)) {
                foreach ($books as $book) {
                    $bookAuthor = new BookAuthor;
                    $bookAuthor->author_id = $author_id;
                    $bookAuthor->book_id = $book;
                    $bookAuthor->save();
                }
            }
            $route = $route->with('message', 'Հեղինակը հաջողությամբ ստեղծվել է');
        }
        return $route;
    }
    public function update(string $name, string $surname, array $books, $id)
    {
        $author = Author::with('booksAuthors')->find($id);
        $user = $author->user;
        $user->fill(['name' => $name, 'surname' => $surname]);
        $author->fill(['name' => $name, 'surname' => $surname]);
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
    }
    public function delete($id)
    {
        $author = Author::find($id);
        $user = $author->user;
        if ($author) {
            $author->delete();
            $user->delete();
        }
    }
}

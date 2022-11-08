<?php


namespace App\Services;

use App\Models\Author;
use App\Models\BookAuthor;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class BookService
{
    public function getCart()
    {
        $cartBooks = [
            'books' => [],
            'qty' => []
        ];
        $cart = json_decode(Cookie::get('cart'), true);
        foreach ($cart as $book_id => $qty) {
            $cartBooks['books'][] = Book::find($book_id);
            $cartBooks['qty'][] = $qty;
        }
        return $cartBooks;
    }
    public function getPaginatedBooks(?string $searchTitle)
    {
        $user = auth('web')->user();
        if ($user->role == User::ROLE_AUTHOR) {
            $author = $user->author;
            $query = $author->books();
        } elseif ($user->role == User::ROLE_ADMIN || $user->role == User::ROLE_CUSTOMER) {
            $query = Book::with('authors');
        }
        if ($searchTitle) {
            $query = $query->where('title', 'like', '%' . $searchTitle . '%');
        }
        $books = $query->paginate(3);
        $view = view('book.index', compact('books'))->with('count', $books->count());
        if ($user->role == User::ROLE_CUSTOMER && Cookie::get('cart')) {
            $view->with('cart', $this->getCart());
        }
        return $view;
    }
    public function addBook(string $title, float $price, int $qty, ?array $authors)
    {
        $user = auth('web')->user();
        if (!$user) {
            $user = auth('sanctum')->user();
        }
        $book = new Book;
        $book->fill(['title' => $title, 'price' => $price, 'qty' => $qty]);
        $book->save();
        $book_id = $book->id;
        if ($user->role == User::ROLE_AUTHOR) {
            $authors = [$user->author->id];
        }
        foreach ($authors as $author) {
            $bookAuthor = new BookAuthor;
            $bookAuthor->fill(['author_id' => $author, 'book_id' => $book_id]);
            $bookAuthor->save();
        }
        return $book_id;
    }
    public function update(string $title, float $price, ?array $authors, int $id)
    {
        $user = auth('web')->user();
        $book = Book::with('booksAuthors')->find($id);
        $book->fill(['title' => $title, 'price' => $price]);
        if ($user->role == User::ROLE_ADMIN) {
            $booksAuthorsId = [];
            foreach ($book->booksAuthors as $author_books) {
                $booksAuthorsId[] = $author_books->author_id;
            }
            $deletedRepeatOne = array_diff($booksAuthorsId, $authors);
            $deletedRepeatTwo = array_diff($authors, $booksAuthorsId);
            if (!empty($deletedRepeatOne)) {
                BookAuthor::where('book_id', $id)->whereIn('author_id', $deletedRepeatOne)->delete();
            }
            if (!empty($deletedRepeatTwo)) {
                foreach ($deletedRepeatTwo as $author) {
                    $bookAuthor = new BookAuthor;
                    $bookAuthor->fill(['author_id' => $author, 'book_id' => $id]);
                    $bookAuthor->save();
                }
            }
        }
        $book->save();
    }
    public function delete(int $id)
    {
        $book = Book::find($id);
        if ($book) {
            $book->delete();
        }
    }
    public function show(int $id)
    {
        $user = auth('web')->user();
        $book = Book::with('authors')->find($id);
        $authors = Author::all();
        if ($user->role == User::ROLE_CUSTOMER && Cookie::get('cart')) {
            return ['book' => $book, 'authors' => $authors, 'cart' => $this->getCart()];
        }
        return ['book' => $book, 'authors' => $authors];
    }
    public function edit(int $id)
    {
        $book = Book::with('authors')->find($id);
        $query = User::where('role', User::ROLE_AUTHOR);
        $authors = $query->with('author')->get();
        return ['book' => $book, 'authors' => $authors];
    }
}

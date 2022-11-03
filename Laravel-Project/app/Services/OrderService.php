<?php


namespace App\Services;


use App\Models\Book;
use App\Models\Order;
use App\Models\OrderBook;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class OrderService
{
    public function index()
    {
        $user = auth('web')->user();
        if ($user->role == User::ROLE_CUSTOMER) {
            $orders = $user->orders;
            $resultVariable = compact('orders');
        } elseif ($user->role == User::ROLE_ADMIN) {
            $orders = Order::all();
            $resultVariable = compact('orders');
        } elseif ($user->role == User::ROLE_AUTHOR) {
            $books = $user->author->books()->with('orderBooks')->get();
            $resultVariable = compact('books');
        }
        return $resultVariable;
    }
    public function transactionCrt(array $authorTransaction, object $user, int $order_id)
    {
        foreach ($authorTransaction as $book_id) {
            foreach ($book_id['user_ids'] as $user_id) {
                $bookQty = $book_id['qty'];
                $bookPrice = $book_id['book_price'];
                $authorsCount = $book_id['count'];
                $resultAmount = ($bookPrice * $bookQty) / $authorsCount;
                $transaction = new Transaction;
                $transaction->fill(['from_user_id' => $user->id, 'to_user_id' => $user_id, 'amount' => $resultAmount, 'order_id' => $order_id]);
                if ($transaction->save()) {
                    $authorUser = User::find($user_id);
                    $authorUser->balance += $resultAmount;
                    $user->balance -= $bookPrice * $bookQty;
                    $user->save();
                    $authorUser->save();
                }
            }
        }
    }
    public function ordBookCrt($cart, $order_id)
    {
        $authorTransaction = [];
        foreach ($cart as $book_id => $qty) {
            $book = Book::find($book_id);
            $authorTransaction[$book_id] = array(
                'user_ids' => [],
                'count' => 0,
                'book_price' => $book->price,
                'qty' => $qty
            );
            foreach ($book->authors as $author) {
                $authorTransaction[$book_id]['count']++;
                $userAuthor = $author->user;
                $authorTransaction[$book_id]['user_ids'][] = $userAuthor->id;
            }
            $orderBook = new OrderBook;
            $orderBook->fill(['order_id' => $order_id, 'book_id' => $book_id, 'qty' => $qty]);
            if ($orderBook->save()) {
                $book->qty -= $qty;
                $book->save();
            }
        }
        return $authorTransaction;
    }
    public function create(float $total)
    {
        if (Cookie::get('cart')) {
            $user = auth('web')->user();
            if ($user->balance < $total) {
                return false;
            }
            $cart = json_decode(Cookie::get('cart'), true);
            $order = new Order;
            $order->fill(['user_id' => $user->id, 'sum' => $total]);
            $order->save();
            $order_id = $order->id;
            $authorTransaction = $this->ordBookCrt($cart, $order_id);
            $this->transactionCrt($authorTransaction, $user, $order_id);
            Cookie::queue(Cookie::forget('cart'));
            return true;
        }
    }
}

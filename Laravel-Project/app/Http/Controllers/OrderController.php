<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Order;
use App\Models\Book;
use App\Models\OrderBook;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
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
        return view('order.index', $resultVariable);
    }

    public function create(Request $request)
    {
        if (Cookie::get('cart')) {
            $user = auth('web')->user();
            $total = $request->input('total');
            if ($user->balance < $total) {
                return redirect()->back()->with('cartMessage', 'Ձեր գումարը բավարար չե պատվիրելու համար');
            }
            $cart = json_decode(Cookie::get('cart'), true);
            $order = new Order;
            $order->fill(['user_id' => $user->id, 'sum' => $total]);
            $order->save();
            $order_id = $order->id;
            $authorTransaction = array();
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
                    array_push($authorTransaction[$book_id]['user_ids'], $userAuthor->id);
                }
                $orderBook = new OrderBook;
                $orderBook->fill(['order_id' => $order_id, 'book_id' => $book_id, 'qty' => $qty]);
                if ($orderBook->save()) {
                    $book->qty -= $qty;
                    $book->save();
                }
            }
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
            Cookie::queue(Cookie::forget('cart'));
            return redirect()->back()->with('orderedMessage', 'Պատվերն ընդունված է և պատրաստվում է առաքման շնորհակալություն գնումների համար');
        }
    }
}

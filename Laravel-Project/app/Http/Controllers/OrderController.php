<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderBook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        if (Session::get('cart')) {
            $total = $request->input('total');
            $cart = Session::get('cart');
            $user = auth('web')->user();
            $order = new Order;
            $order->fill(['user_id' => $user->id, 'sum' => $total]);
            $order->save();
            $order_id = $order->id;
            foreach ($cart as $crt) {
                $orderBook = new OrderBook;
                $orderBook->fill(['order_id' => $order_id, 'book_id' => $crt[0], 'qty' => $crt[1]]);
                $orderBook->save();
            }
            Session::forget('cart');
            return redirect()->back()->with('orderedMessage', 'Պատվերն ընդունված է և պատրաստվում է առաքման շնորհակալություն գնումների համար');
        }
    }
}

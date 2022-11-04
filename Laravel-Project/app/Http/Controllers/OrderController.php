<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Order;
use App\Models\Book;
use App\Models\OrderBook;
use App\Models\Transaction;
use App\Models\User;
use App\Services\AuthService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index(OrderService $orderService)
    {
        return view('order.index', $orderService->getOrders());
    }

    public function create(Request $request, OrderService $orderService)
    {
        if ($orderService->create($request->total)) {
            return redirect()->back()->with('orderedMessage', 'Պատվերն ընդունված է և պատրաստվում է առաքման շնորհակալություն գնումների համար');
        }
        return redirect()->back()->with('cartMessage', 'Ձեր գումարը բավարար չե պատվիրելու համար');
    }
}

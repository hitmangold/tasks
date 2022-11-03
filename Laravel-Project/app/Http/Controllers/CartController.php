<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Services\CartService;

class CartController extends Controller
{
    public function add(Request $request, CartService $cartService)
    {
        $cartService->addCart($request->input('qty'), $request->input('book_id'));
        return redirect()->back();
    }
}

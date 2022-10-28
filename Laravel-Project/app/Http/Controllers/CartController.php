<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $qty = $request->input('qty');
        $book_id = $request->input('book_id');
        $userCart = Session::get('cart');
        if (!$userCart) {
            $cart = [[$book_id,$qty]];
            Session::put('cart', $cart);
        } else {
            $checkExistCart = 0;
            foreach ($userCart as & $crt) {
                if ($crt[0] == $book_id) {
                    $crt[1] += $qty;
                    $checkExistCart = 1;
                }
            }
            if ($checkExistCart == 0) {
                $cart = [$book_id,$qty];
                array_push($userCart, $cart);
            }
            Session::forget('cart');
            Session::put('cart', $userCart);
        }
        return redirect()->back();
    }
}

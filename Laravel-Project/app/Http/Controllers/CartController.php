<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $qty = $request->input('qty');
        $book_id = $request->input('book_id');
        $userCart = Cookie::get('cart');
        if (!$userCart) {
            $cart = array();
            $cart[$book_id] = $qty;
            Cookie::queue('cart', json_encode($cart), 864000);
        } else {
            $userCart = json_decode($userCart, true);
            $checkExistCart = 0;
            foreach ($userCart as $bk_id => $q) {
                if ($bk_id == $book_id) {
                    $userCart[$bk_id] += $qty;
                    $checkExistCart = 1;
                }
            }
            if ($checkExistCart == 0) {
                $userCart[$book_id] = $qty;
            }
            Cookie::unqueue('cart');
            Cookie::queue('cart', json_encode($userCart), 864000);
        }
        return redirect()->back();
    }
}

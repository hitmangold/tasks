<?php


namespace App\Services;

use Illuminate\Support\Facades\Cookie;

class CartService
{
    public function addCart(int $qty, int $book_id)
    {
        $userCart = Cookie::get('cart');
        if (!$userCart) {
            $cart = [];
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
    }
}

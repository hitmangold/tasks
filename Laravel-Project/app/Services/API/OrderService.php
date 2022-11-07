<?php


namespace App\Services\API;


use App\Models\Order;
use App\Models\User;

class OrderService
{
    public function getOrders()
    {
        $user = auth('sanctum')->user();
        if ($user->role == User::ROLE_CUSTOMER) {
            $orders = $user->orders;
        } elseif($user->role == User::ROLE_ADMIN) {
            $orders = Order::all();
        } elseif($user->role == User::ROLE_AUTHOR) {
            $books = $user->author->books()->get();
        }
        $data = [
            'status' => true,
            'message' => 'Orders information',
            'orders' => []
        ];
        if ($user->role != User::ROLE_AUTHOR) {
            foreach ($orders as $order) {
                $data['orders'][$order->id] = [
                    'user_id' => $order->user_id,
                    'order_amount' => $order->sum,
                    'order_date' => $order->created_at,
                ];
                foreach ($order->orderBook as $book) {
                    $data['orders'][$order->id]['books'][$book->id] = [
                        'title' => $book->title,
                        'price' => $book->price,
                        'qty' => $book->pivot->qty
                    ];
                }
            }
        } else {
            foreach ($books as $book) {
                $data['orders']['books'][$book->id] = [
                    'title' => $book->title,
                    'price' => $book->price,
                    'users' => []
                ];
                $count = 0;
                foreach ($book->orderBooks as $orderBook) {
                    $count++;
                    $data['orders']['books'][$book->id]['users'][$count] = [
                        'name' => $orderBook->order->user->name,
                        'surname' => $orderBook->order->user->surname,
                        'order_date' => $orderBook->created_at,
                        'qty' => $orderBook->qty
                    ];
                }
                /*foreach ($book->orderBooks as $order) {
                    dd($order);
                }*/
            }
        }
        return response()->json($data, 200);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderService $orderService)
    {
        try {
            $orders = $orderService->getOrders();

            return $orders;

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

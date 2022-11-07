<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function info()
    {
        $user = auth('sanctum')->user();
        return response()->json([
            'status' => true,
            'message' => 'User Information',
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email
        ], 200);
    }
}

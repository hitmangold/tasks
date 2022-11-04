<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Requests\API\AuthRequest;
use App\Models\User;
use App\Services\API\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function regProccess(AuthService $authService, RegisterRequest $registerRequest)
    {
        $authService->register($registerRequest->name, $registerRequest->surname, $registerRequest->email, $registerRequest->password, $registerRequest->role);
        return response()->json(['message' => 'Вы успешно зарегистрировались'], 200);
    }
    public function loginProccess(AuthRequest $authRequest, AuthService $authService)
    {
        try {
            $response = $authService->login($authRequest->email, $authRequest->password);

            return $response;

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

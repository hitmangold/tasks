<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Author;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function regProccess(RegisterRequest $request, AuthService $authService)
    {
        $authService->register($request->name, $request->surname, $request->email, $request->password, $request->role);
        return redirect(route('books.index'));
    }

    public function authProccess(AuthRequest $request, AuthService $authService)
    {
        if ($authService->login($request->email, $request->password)) {
            return redirect(route('books.index'));
        }
        return redirect(route('login'))->withErrors(['email' => 'User not found or data entered incorrectly']);
    }

    public function logout()
    {
        auth("web")->logout();
        return redirect(route('login'));
    }
}

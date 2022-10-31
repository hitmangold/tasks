<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\User;
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

    public function regProccess(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $userCreate = [
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'password' => app('hash')->make($request->input('password'))
        ];

        if ($request->input('role') == 'customer') {
            $userCreate['role'] = User::ROLE_CUSTOMER;
        } elseif ($request->input('role') == 'author') {
            $userCreate['role'] = User::ROLE_AUTHOR;
        }

        $user = User::create($userCreate);

        if ($user) {
            $author = new Author;
            $author->fill(['name' => $request->input('name'), 'surname' => $request->input('surname'), 'user_id' => $user->id]);
            $author->save();
            auth("web")->login($user);
        }

        return redirect(route('books.index'));
    }

    public function authProccess(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (auth("web")->attempt($data)) {
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

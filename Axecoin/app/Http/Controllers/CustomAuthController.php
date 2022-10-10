<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function home()
    {
        return view("homepage");
    }
    public function index()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view("login");
    }
    public function reg()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view("reg");
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'checked' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->with('message', 'signed in');
        }
        return redirect('/login')->with('message', 'Login details are not valid');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'checked' => 'required'
        ]);
        $data = $request->all();
        $check = $this->create($data);

        return redirect('dashboard');
    }
    public function create($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect('login');
    }
}

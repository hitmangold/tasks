<?php


namespace App\Services\API;


use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(string $name, string $surname, string $email, string $password, string $role)
    {
        $userCreate = [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => app('hash')->make($password)
        ];
        if ($role == 'customer') {
            $userCreate['role'] = User::ROLE_CUSTOMER;
        } elseif ($role == 'author') {
            $userCreate['role'] = User::ROLE_AUTHOR;
        }
        $user = User::create($userCreate);
        if ($user) {
            $author = new Author;
            $author->fill(['name' => $name, 'surname' => $surname, 'user_id' => $user->id]);
            $author->save();
        }
    }
    public function login(string $email, string $password)
    {
        if(!Auth::attempt(['email' => $email, 'password' => $password])){
            return response()->json([
                'status' => false,
                'message' => 'E-mail или пароль введено не верно',
            ], 401);
        }

        $user = User::where('email', $email)->first();
        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
        ], 200);
    }
}

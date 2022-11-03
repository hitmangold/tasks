<?php


namespace App\Services;


use App\Models\Author;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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
            auth("web")->login($user);
        }
    }

    public function login(string $email, string $password)
    {
        if (auth("web")->attempt(['email' => $email, 'password' => $password])) {
            return true;
        }
    }
}

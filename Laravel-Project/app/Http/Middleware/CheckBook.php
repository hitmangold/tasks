<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckBook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('web')->user();
        $id = $request->route()->parameters()['book'];
        if($user->role == User::ROLE_AUTHOR) {
            $userBooks = $user->author->books->find($id);
            if (!$userBooks) {
                return redirect()->route('books.index');
            }
        }
        return $next($request);
    }
}

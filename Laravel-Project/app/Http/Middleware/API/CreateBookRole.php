<?php

namespace App\Http\Middleware\API;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CreateBookRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth('sanctum')->user();
        if ($user->role != User::ROLE_AUTHOR && $user->role != User::ROLE_ADMIN) {
            return response()->json([
                'status' => false,
                'message' => 'У вас нет досуп к этому запросу'
            ], 403);
        }
        return $next($request);
    }
}

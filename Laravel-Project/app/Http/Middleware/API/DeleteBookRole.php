<?php

namespace App\Http\Middleware\API;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class DeleteBookRole
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
        $id = $request->id;
        if ($user->role == User::ROLE_AUTHOR) {
            $userBooks = $user->author->books->find($id);
            if (!$userBooks) {
                return response()->json([
                    'status' => false,
                    'message' => 'Произошла ошибка! книга не найдено!'
                ], 500);
            }
        } elseif ($user->role == User::ROLE_CUSTOMER) {
            return response()->json([
                'status' => false,
                'message' => 'У вас нет доступ к этому запросу'
            ], 403);
        }
        return $next($request);
    }
}

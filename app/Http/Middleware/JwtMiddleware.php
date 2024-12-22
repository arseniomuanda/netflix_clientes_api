<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Verificar se o usuário existe
            if (!$user) {
                throw new JWTException('User not found');
            }

            return $next($request);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not valid'], 401);
        }
    }
}

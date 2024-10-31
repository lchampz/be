<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            
            $user = JWTAuth::parseToken()->authenticate();

            
            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }
        } catch (TokenExpiredException $e) {
            
            return response()->json(['error' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (JWTException $e) {
            
            return response()->json(['error' => 'Token ausente'], 401);
        }

        
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth; // Importando o facade Auth corretamente
use Closure;
use Illuminate\Http\Request;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!Auth::guest()) abort(404, "Página não encontrada");

        return $next($request);
    }
}

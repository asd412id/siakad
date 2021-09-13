<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (!in_array(auth()->user()->role, $guards)) {
            if (request()->ajax()) {
                return response()->json(['message' => 'Akses ditolak!'], 406);
            }
            return redirect()->route('home')->withErrors('Akses ditolak!');
        }
        return $next($request);
    }
}

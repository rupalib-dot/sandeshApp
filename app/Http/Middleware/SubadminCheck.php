<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SubadminCheck
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
        $roles = Auth::check() ? Auth::user()->userRole->pluck('name')->toArray() : [];

        if (in_array('subAdmin', $roles)) {
            return redirect('/');
        } else {
            return $next($request);
        }

    }
}

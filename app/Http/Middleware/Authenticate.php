<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request)
    {
        if (! $request->expectsJson() ) {
            return route('login');
        } 
        
    }

    public function handle(Request $request, Closure $next, ... $roles)
    {
        if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
            return redirect('login');

        foreach($roles as $role) {
            if(Auth::user()->status_id == $role || $role == 'logout')
                return $next($request);
        }

        return redirect('login');
    }
}

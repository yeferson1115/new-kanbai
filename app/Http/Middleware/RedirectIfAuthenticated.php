<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $role = Auth::user()->role;             
            switch ($role) {
                case 'Usuario':
                   return redirect('/user_dashboard');
                   break;
                case 'Empresa':
                    return redirect('/user_dashboard');
                    break;                 
                default:
                    return redirect(RouteServiceProvider::HOME);
                   break;
              }
            
        }

        return $next($request);
    }
}

<?php namespace Classiebit\Eventmie\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OrganiserMiddleware {

    public function handle($request, Closure $next)
    {
        
        if(Auth::guard('admin')->check() && (Auth::guard('admin')->user()->hasRole('organiser') || Auth::guard('admin')->user()->hasRole('admin')) )
        {
        
            return $next($request);
           
        }
        
        return redirect()->route('eventmie.welcome');
    }
}
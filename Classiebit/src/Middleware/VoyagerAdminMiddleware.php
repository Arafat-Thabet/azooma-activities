<?php

namespace Classiebit\Eventmie\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VoyagerAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        

        auth()->setDefaultDriver(app('VoyagerGuard'));
        if (!Auth::guest()) {
            $user = Auth::guard('admin')->user();
            $user->can('browse_admin');
         //  dd($user->hasPermission('browse_admin'));
             // if user lang
            if(session('my_lang'))
                \App::setLocale(session('my_lang'));

            return $user->hasPermission('browse_admin') ? $next($request) : redirect('/');
        }
        $urlLogin = route('voyager.login');

        return redirect()->guest($urlLogin);
    }
}

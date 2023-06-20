<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        if (Auth::guard($guard)->check()) {
//            return redirect(RouteServiceProvider::HOME);
//        }

        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    $status = Auth::guard($guard)->user()->status;
                    if ($status == "Active") {
                        return redirect()->route('admin.dashboard');
                    } else {

                    }
                }
                break;

            case 'author':
                if (Auth::guard($guard)->check()) {
                    $status = Auth::guard($guard)->user()->status;
                    if ($status == "Active") {
                        return redirect()->route('author.dashboard');
                    } else {

                    }
                }
                break;
        }

        return $next($request);
    }
}

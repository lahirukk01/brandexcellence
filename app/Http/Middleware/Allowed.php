<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Allowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        return $next($request);

        if(Auth::guard('admin')->check()) {
            return $next($request);
        }

        if(Auth::guard('judge')->check()) {
            if(Auth::user()->allowed) {
                return $next($request);
            } else {
                return redirect()->action('Auth\LoginController@logout')->with('error', 'You have been blocked by admin');
            }
        } else if(Auth::guard('auditor')->check()) {
            if(Auth::user()->allowed) {
                return $next($request);
            } else {
                return redirect()->action('Auth\LoginController@logout')->with('error', 'You have been blocked by admin');
            }
        } else if(Auth::guard('client')->check()) {
            if(Auth::user()->allowed) {
                return $next($request);
            } else {
                return redirect()->action('Auth\LoginController@logout')->with('error', 'You have been blocked by admin');
            }
        } else {
            die('Invalid login type');
        }
    }
}

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
        if(Auth::guard('admin')->check()) {
            return $next($request);
        }

        if(Auth::guard('judge')->check()) {
            if(Auth::user()->allowed) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->action('Auth\JudgeLoginController@showLoginForm')->with('userBlocked', 'You have been blocked by admin');
            }
        } else if(Auth::guard('auditor')->check()) {
            if(Auth::user()->allowed) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->action('Auth\AuditorLoginController@showLoginForm')->with('userBlocked', 'You have been blocked by admin');
            }
        } else if(Auth::guard('client')->check()) {
            if(Auth::user()->allowed) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->action('Auth\LoginController@showLoginForm')->with('userBlocked', 'You have been blocked by admin');
            }
        } else {
            die('Invalid login type');
        }
    }
}

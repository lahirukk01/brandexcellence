<?php

namespace App\Http\Middleware;

use App\Judge;
use Closure;
use Illuminate\Support\Facades\Auth;

class JudgeFirstTimePwReset
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
        if(Auth::check()) {
            if (Auth::user()->first_time_password_reset) {
                return $next($request);
            } else {
                return redirect()->route('judge.show_password_reset_form');
            }
        }
        return redirect()->back();
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Get the user's last activity time from the session
        $lastActivityTime = Session::get('lastActivityTime');

        // Check if the user has been inactive for more than 15 minutes
        if (time() - $lastActivityTime > 900) {
            Auth::logout();
            Session::flush();
            return redirect('/login')->with('error', 'Session expired due to inactivity');
        }

        // Update the user's last activity time in the session
        Session::put('lastActivityTime', time());

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check())
        {
            // Get the currently authenticated user
            $user = Auth::user();

            // Check if the user is inactive
            if ($user->status=="INACTIVE")
            {
                Auth::logout();
                // Redirect to an inactive user page or return an appropriate response
                return redirect('/login')->withErrors(['email'=>'These credentials do not match our records.']);
            }
        }

        return $next($request);
    }
}

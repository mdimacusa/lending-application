<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
class CreateClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Route::currentRouteName()=="client.profile.create");
        {
            if (!auth()->user()->can('create','client'))
            {
                abort(403,'Unauthorized action.');
            }
            return $next($request);
        }
        return $next($request);
    }
}

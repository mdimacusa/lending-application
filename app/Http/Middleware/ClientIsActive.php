<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Soa;
class ClientIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $reference = $request->segments();
        $data = Soa::with('client:id,status')->where('reference',end($reference))->firstOrFail();
        if($data->client->status != "ACTIVE")
        {
            return back()->with('swal.error','Client email is inactive.');
        }
        return $next($request);
    }
}

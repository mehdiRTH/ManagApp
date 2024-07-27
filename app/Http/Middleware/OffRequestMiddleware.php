<?php

namespace App\Http\Middleware;

use App\Models\OffRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OffRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $offRequest=$request->route('off_request');
        if(Auth::user()->id==$offRequest->user->id || hasRole('HR'))
        {
            return $next($request);
        }

        return redirect()->route('off_requests.index');

    }
}

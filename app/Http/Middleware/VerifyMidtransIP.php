<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyMidtransIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedIPs = [
            '54.169.151.247', // IP Sandbox Midtrans
            '52.221.231.42',  // IP Production Midtrans
        ];

        if (!in_array($request->ip(), $allowedIPs)) {
            abort(403, 'Unauthorized IP');
        }

        return $next($request);
    }
}

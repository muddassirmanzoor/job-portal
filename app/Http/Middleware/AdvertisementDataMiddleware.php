<?php

namespace App\Http\Middleware;

use App\Models\Advertisement;
use App\Models\Job;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve advertisements from the database
        $advertisements = Advertisement::all();
        // Share the data globally
        View::share('advertisements', $advertisements);

        return $next($request);
    }
}

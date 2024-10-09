<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
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
        
        $response = $next($request);
        $origin = $request->headers;
        \Log::info('Request Origin: ' . $origin);

        
        // Allow all origin
        //$response->headers->set('Access-Control-Allow-Origin', '*');
 
        // Allow other CORS headers
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
 
        // Handle OPTIONS request
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 200)
                //->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        }
 
        return $response;
    }
}

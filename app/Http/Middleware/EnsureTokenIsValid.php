<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if we received a header secret
        if (!$request->header('HeaderSecret')) {
            return response(["message" => "Secret Key Required"]);
        }
        // Validate request header with secret key
        $apiKey =  $request->header('HeaderSecret');
        $partners = config('custom_key.partners');
        $validKey = false;
        for($i=0; $i < count($partners); $i++){
            $secret_key = $partners[$i]['HeaderSecret'];
            if ($apiKey === $secret_key) {
                $validKey = true;
                break;
            }
        }
        if(!$validKey){
            return response(["message" => "Invalid Secret Key"]);
        }

        return $next($request);
    }
}

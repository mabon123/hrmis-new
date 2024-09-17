<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role, $permission=null)
    {
        if (!$request->user()->hasRole($role)) {
            return redirect()->route('page.notfound', app()->getLocale());
        }

        if ($permission !== null && !$request->user()->can($permission)) {
            return redirect()->route('page.notfound', app()->getLocale());
        }
        
        return $next($request);
    }
}

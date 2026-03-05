<?php

namespace App\Http\Middleware;

use Closure;

class IsBroker
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
        if(auth()->user()->is_broker()) {
            return $next($request);
        }
        //return redirect('/');
         return abort(403, 'Unauthorized');
    }
    
    /*public function handle($request, Closure $next){
        if (auth()->check() && auth()->user()->roles()->where('slug', 'broker')->exists()) {
            return $next($request);
        }

        return abort(403, 'Unauthorized');
    }*/
}

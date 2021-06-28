<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$role)
    {
        if($request->user()->role!=$role){
            if($request->user()->role=='admin'){
                return $next($request);
            }
            else{
                return abort(403, '權限錯誤');
            }
        }
        return $next($request);
    }
}

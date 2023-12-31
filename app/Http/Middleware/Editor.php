<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Editor
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
        if (Auth::check() && Auth::check() && (Auth::user()->type == 'author' ||Auth::user()->type == 'admin'||Auth::user()->type == 'editor')) {

            return $next($request);
        }
        else{
            return redirect()->back()->with(['message'=>'Sorry ! you can not access this']);
        }
    }
}

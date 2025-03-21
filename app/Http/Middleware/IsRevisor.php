<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsRevisor
{

    public function handle(Request $request, Closure $next): Response{
        if(Auth::check() && Auth::user()->is_revisor){
            return $next($request);
        }
        return redirect()->route('homepage')->wth('errorMessage','Zona riservata ai revisori');
    }
 }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */



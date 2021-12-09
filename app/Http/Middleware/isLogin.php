<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isLogin
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);

    }
}

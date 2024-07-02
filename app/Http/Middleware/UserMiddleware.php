<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;



class UserMiddleware{

    public function handle(Request $request, Closure $next): Response{
        if (Auth::check() && Auth::user()->role_id == 2) {
            return $next($request);
        }else{
            return redirect()->route('login');
        }
    }
}

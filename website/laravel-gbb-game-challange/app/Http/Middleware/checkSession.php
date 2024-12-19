<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkSession
{
    public function handle(Request $req, Closure $next)
    {
        if(!$req->session()->has('admin')){
            return redirect('login');
        }
        return $next($req);
    }
}

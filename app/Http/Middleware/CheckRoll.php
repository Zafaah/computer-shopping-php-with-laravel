<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


function isAllowed($menus, $link){
    foreach ($menus as $menu){
        if ($menu->link == $link) return true;
    }

    return false;
}

class CheckRoll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->uri;
        $user_rolls = session()->get('menus');

        if (!isAllowed($user_rolls, $route)){
            error_log($user_rolls);
            return redirect('/');
        }else{
            return $next($request);
        } 
    }
}

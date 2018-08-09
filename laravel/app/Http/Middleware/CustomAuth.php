<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$accepts)
    {
        if (!in_array(session('level'), $accepts)) {
            return redirect(action('WelcomeController@index'));
            // echo 'not login';
        } else {
            return $next($request);
            // echo 'login';
        }

        die;
    }
}

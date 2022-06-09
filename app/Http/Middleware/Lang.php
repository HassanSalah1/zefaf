<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = $request->header('lang'); // string

        if(!empty($lang)){
            App::setLocale($lang);
        }else
            App::setLocale('en');

        return $next($request);
    }
}

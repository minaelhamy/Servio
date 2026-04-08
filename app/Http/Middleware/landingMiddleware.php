<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\helper\helper;

class landingMiddleware
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
        date_default_timezone_set(@helper::appdata(1)->timezone);
        @helper::language(1);
        $user = User::where('slug', $request->vendor)->first();

        if (!empty($user) && @helper::otherappdata($user->id)->maintenance_on_off == 1) {
            return response(view('errors.maintenance'));
        }

        return $next($request);
    }
}   

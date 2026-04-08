<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\helper\helper;
class usermiddleware
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
        if (Auth::user() && Auth::user()->type == 3) {
            $user = helper::currentStoreUser($request->route('vendor'));

            if (!empty($user)) {
                date_default_timezone_set(@helper::appdata($user->id)->timezone);
                @helper::language($user->id);
            }

            return $next($request);
        }

        $storeSlug = $request->route('vendor') ?: optional(helper::currentStoreUser())->slug;

        return !empty($storeSlug)
            ? redirect(helper::storefront_url($storeSlug))
            : redirect('/');
    }
}

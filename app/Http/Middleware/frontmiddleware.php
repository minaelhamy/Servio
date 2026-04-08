<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\helper\helper;
use App\Models\Settings;

class frontmiddleware
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
        $vendordata = helper::currentStoreUser($request->route('vendor'));

        if (empty($vendordata)) {
            abort(404);
        }

        date_default_timezone_set(@helper::appdata($vendordata->id)->timezone);
        @helper::language($vendordata->id);

        if (@helper::otherappdata($vendordata->id)->maintenance_on_off == 1) {
            return response(view('errors.maintenance'));
        }

        $checkplan = @helper::checkplan($vendordata->id, '3');
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2) {
            return response(view('errors.accountdeleted'));
        }

        if (@$vendordata->is_available == 2) {
            return response(view('errors.accountdeleted'));
        }

        return $next($request);
    }
}

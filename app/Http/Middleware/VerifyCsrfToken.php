<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'admin/plan/*',
        '*/mercadoordersuccess',
        '*/paymentsuccess',
        '*/embedded/timeslot',
        '*/service/timeslot',
        '*/service/slotlimit',
        '*/service/stafflimit',
        '*/service/booking',
        '*/addwalletsuccess',
        '*/addfail',
    ];
}

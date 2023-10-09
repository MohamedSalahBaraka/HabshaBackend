<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Interfaces\MustVerifyMobile;
use App\Models\Setting;
use Illuminate\Support\Facades\Redirect;

class VerifiedPaymentsMiddleware
{
    public function handle(Request $request, Closure $next, $redirectToRoute = null)
    {
        $Payment = Setting::where('key', 'Payment')->first();
        if (is_null($Payment)) {
            return abort(500);
        }

        return $next($request);
    }
}
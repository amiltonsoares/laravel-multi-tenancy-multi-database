<?php

namespace App\Http\Middleware\Tenant;

use Closure;

class CheckDomainMainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $host = $request->getHost();
        $main = config('tenant.domain_main');

        if ($host != $main) {
            abort(401);
        }
        return $next($request);
    }
}

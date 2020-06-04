<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use Closure;

class TenantMiddleware
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
        $company = $this->getCompany($request->getHost());

        if (!$company && $request->url() != route('404.tenant')) {
            return redirect()->route('404.tenant');
        }
        return $next($request);
    }

    public function getCompany($host)
    {
        return Company::where('domain', $host)->first();
    }
}

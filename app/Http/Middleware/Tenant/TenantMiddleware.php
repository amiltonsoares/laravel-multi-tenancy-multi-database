<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
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
        $manager = app(ManagerTenant::class);
        $host = $request->getHost();
        $company = $this->getCompany($host);

        if (!$company && $request->url() != route('404.tenant') && !$manager->domainIsMain()) {
            return redirect()->route('404.tenant');
        } else if ($request->url() != route('404.tenant') && !$manager->domainIsMain()) {
            $manager->setConnection($company);
        }
        return $next($request);
    }

    public function getCompany($host)
    {
        return Company::where('domain', $host)->first();
    }
}

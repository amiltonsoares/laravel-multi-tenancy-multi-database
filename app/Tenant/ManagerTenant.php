<?php

namespace App\Tenant;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{
    public function setConnection(Company $company)
    {
        DB::purge('tenant');

        config()->set('database.connections.tenant.database', $company->bd_database);
        config()->set('database.connections.tenant.host', $company->bd_hostname);
        config()->set('database.connections.tenant.username', $company->bd_username);
        config()->set('database.connections.tenant.password', $company->bd_password);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();
    }

    public function domainIsMain(){
        return (request()->getHost() == config('tenant.domain_main'));
    }
}

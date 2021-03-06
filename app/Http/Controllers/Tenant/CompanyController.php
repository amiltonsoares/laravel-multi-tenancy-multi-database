<?php

namespace App\Http\Controllers\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{

    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function store(Request $request)
    {
        $index = Str::random(5);
        $company = $this->company->create([
            'name' => 'Cliente ' . $index,
            'domain' => "cliente{$index}.multidabase.test",
            'bd_hostname' => 'mysql',
            'bd_database' => 'multi_database_' . $index,
            'bd_username' => 'root',
            'bd_password' => 'QaZ34237510',
        ]);

        if (false)
            event(new CompanyCreated($company));
        else
            event(new DatabaseCreated($company));

        dd($company);
    }
}

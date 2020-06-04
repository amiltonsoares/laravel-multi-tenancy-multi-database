<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrations Tenants';

    protected $managerTenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $managerTenant)
    {
        parent::__construct();
        $this->managerTenant = $managerTenant;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        $companies = Company::all();

        foreach ($companies as  $company) {
            $this->managerTenant->setConnection($company);
            $this->info("Connecting Company {$company->name}");
            $result = Artisan::call($command, [
                '--force' => true,
                '--path' => '/database/migrations/tenants',
            ]);
            $this->info($result);
            $this->info("End Connecting Company {$company->name}");
            $this->info('---------------------------------------');
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Services\SchedulerService;
use Illuminate\Console\Command;

class VendorProfileUpdateScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "vendorprofileupdate:scheduler";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sample scheduler command to update vendor profile on nav system";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $service = new SchedulerService();
        $service->vendorProfileUpdateSoapCall();
    }
}

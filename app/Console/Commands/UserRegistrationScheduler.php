<?php

namespace App\Console\Commands;

use App\Services\SchedulerService;
use Illuminate\Console\Command;

class UserRegistrationScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "userregistraion:scheduler";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sample scheduler command to register the user on nav system";

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
        $service->userRegisterSoapCall();
    }
}

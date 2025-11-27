<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\v1\AdminController;

class PurchaseQuoteSubmissionV3Scheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchasequotesubmissionv3:scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler command to submit purchase quote for V1 on nav system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new AdminController();
        $controller->purchaseQuoteScheduler3();
    }
}

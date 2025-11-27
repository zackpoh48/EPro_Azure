<?php

namespace App\Console\Commands;

use App\Http\Controllers\v1\AdminController;
use Illuminate\Console\Command;

class PurchaseQuoteSubmissionV1Scheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchasequotesubmissionv1:scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler command to submit purchase quote for V1 on nav system';

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
     */
    public function handle()
    {
        //
        $controller = new AdminController();
        $controller->purchaseQuote();
    }
}

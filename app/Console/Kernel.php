<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UserRegistrationScheduler::class,
        Commands\DeliveryOrderSubmissionScheduler::class,
        Commands\VendorProfileUpdateScheduler::class,
        Commands\PurchaseQuoteSubmissionScheduler::class,
        Commands\VendorRegistrationV1Scheduler::class,
        Commands\PurchaseQuoteSubmissionV1Scheduler::class,
        Commands\PurchaseQuoteSubmissionV3Scheduler::class,
        Commands\testConnection::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command("userregistraion:scheduler")->everyMinute();
        $schedule->command("deliveryordersubmission:scheduler")->everyMinute();
        $schedule->command("vendorprofileupdate:scheduler")->everyMinute();
        $schedule->command("purchasequotesubmission:scheduler")->everyMinute();
        $schedule->command("vendorregistrationv1:scheduler")->everyMinute();
        $schedule->command("purchasequotesubmissionv1:scheduler")->everyMinute();
        $schedule->command("purchasequotesubmissionv3:scheduler")->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . "/Commands");

        require base_path("routes/console.php");
    }
}

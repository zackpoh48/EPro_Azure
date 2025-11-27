<?php

namespace App\Console\Commands;

use App\Models\Organization;
use App\Services\DeliveryOrderService;
use Illuminate\Console\Command;

class testConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "test:connection";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Command to test nav connection";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $organization_uuid = $this->ask("Please enter organization unique id?");
        $Company_vendor_no = $this->ask("Please enter company vendor no.?");

        $organization = Organization::where(
            "unique_id",
            $organization_uuid
        )->first();

        $xmlResponse = DeliveryOrderService::getPurchaseOrderList(
            $Company_vendor_no,
            $organization,
            true
        );
        $this->info("Response=>");
        $this->info("Url:");
        $this->line($xmlResponse->url);
        $this->info("headers:");
        $this->line($xmlResponse->headers);
        $this->info("data:");
        $this->line($xmlResponse->data);
    }
}

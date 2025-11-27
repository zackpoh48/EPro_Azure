<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendGrid;

class SendMultipleRfqInviteMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $vendors;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vendors)
    {
        $this->vendors = $vendors;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_array($this->vendors)) {
            foreach ($this->vendors as $key => $value) {
                Mail::to($value->email)->send(new SendGrid($value));
            }
        } else {
            Mail::to($this->vendors->email)->send(new SendGrid($this->vendors));
        }
    }
}

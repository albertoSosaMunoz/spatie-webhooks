<?php 

namespace App\Jobs;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Illuminate\Support\Facades\Log; 

class ProcessWebhook extends ProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`

        // perform the work here
        Log::info('recibido');
    }
}
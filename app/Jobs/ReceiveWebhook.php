<?php

namespace App\Jobs;

use App\Http\Controllers\PruebasShopify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; 

use Spatie\WebhookClient\Jobs\ProcessWebhookJob as SpatieProcessWebhookJob;

class ReceiveWebhook extends SpatieProcessWebhookJob
{
    public function handle()
    {
        // $this->webhookCall // contains an instance of `WebhookCall`
        // perform the work here
        Log::info("recibido" . $this->webhookCall);
        $data=($this->webhookCall->payload);
        dd($data);
        return response('Hello World', 200)
            ->header('x_hook_secret', 'text/plain');
    }
}
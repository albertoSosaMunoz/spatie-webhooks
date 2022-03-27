<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Facades\Log; 


class WebhookController extends Controller
{
    
    public function send_webhook(){

        WebhookCall::create()
            ->url('127.0.0.1:8000/api/webhook-radar')
            ->payload(['action' => 'creado y enciado'])
            ->useSecret('sin secretos')
            ->dispatch();

        Log::info("creado");
    }

}

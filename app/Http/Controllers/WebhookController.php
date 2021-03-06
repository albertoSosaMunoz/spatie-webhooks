<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Facades\Log; 


class WebhookController extends Controller
{
    
    public static function send_webhook(){

        WebhookCall::create()
            ->url('127.0.0.1:8000/api/webhook-radar')
            ->payload(['action' => 'creado y enviado'])
            ->useSecret('1')
            ->dispatch();

        Log::info("creado");
    }

    public static function receive_webhook(Request $request){

        Log::info($request->header('x-hook-secret'));

    }

}

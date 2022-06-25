<?php

use App\Http\Controllers\API\AsanaController;
use App\Http\Controllers\API\ShopifyController;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sendwebhook','App\Http\Controllers\WebhookController@send_webhook');
//Route::get('/receivewebhook','App\Http\Controllers\WebhookController@receive_webhook');
Route::get('/laravelversion', function(){
                                            return app()->version();
                                        }
          );
          
Route::post('/receivewebhook', function (Request $request){   
    
    if( $request->header('x-hook-secret' ) ){
        return response('HANDSHAKE OK', 200)
        ->header('Content-Type', 'text/plain')
        ->header('X-Hook-Secret', $request->header('x-hook-secret'));
    }

    if( ! empty( $request['events'] ) ){
        Log::info($request);    
    }

    $asana_task = $request['asana_task'];
    //coger ultimo story, que seria el mas actual
    $result_asana  = AsanaController::get($asana_api_key, 'tasks/'.$asana_task.'/stories');
    $last_story    = $result_asana;
    //extraigo email del customer de Shopify del html de la tarea asana
    $result_asana  = AsanaController::get($asana_api_key,'task/' . $asana_task);    
    preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $result_asana['html'], $emails_array);
    //buscamos por email en clientify
    foreach ( $emails_array as $single_email){
        $result_clientify = ClientifyController::get($clientify_api_key, ['query' => $single_email]);
        if( !empty($result_clientify)){
            //hemos encontrado en clientify
            foreach($result_clientify['contact'] as $single_contact){
                //creamos la nota en los contactos con la story y el nombre de la tarea
                ClientifyContoller::post($clientify_api_key, 'contacts/' . $single_contact['id'] . '/note/',  );
            }
        }
    }

    
    
});


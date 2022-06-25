<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

define ('API_VERSION', '2022-04');

class ShopifyController extends Controller
{
    public static function get($api_key, $api_password , $api_token , $store_name , $module ){

        $api_version = API_VERSION;
        $url ='https://'. $store_name .'.myshopify.com/admin/api/' . $api_version . '/' . $module . '.json';

        $response = Http::withBasicAuth( $api_key, $api_password)
                        ->withHeaders( ['X-Shopify-Access-Token' => $api_token, 
                                        'Content-Type' => 'application/json'] )
                        ->get($url);

        return $response->json();
    }

    public static function post($api_key, $api_password , $api_token , $store_name, $shopify_product, $module ){

        $api_version = API_VERSION;
        $url ='https://'. $store_name .'.myshopify.com/admin/api/' . $api_version . '/' . $module . '.json';


        $response = Http::withBasicAuth( $api_key, $api_password)
                        ->withHeaders( ['X-Shopify-Access-Token' => $api_token, 
                                        'Content-Type' => 'application/json'] )
                        ->post( $url, [ 'product' =>$shopify_product ] );

        return $response->json();
    }

    public static function set_item_quantity( $api_key, $api_password , $api_token , $store_name, $shopify_product_id, $warehouse_id, $shopify_product_quantity ){

        $api_version = API_VERSION;
        $url ='https://'. $store_name .'.myshopify.com/admin/api/' . $api_version . '/inventory_levels/set.json';

        $response = Http::withBasicAuth( $api_key, $api_password)
                        ->withHeaders( ['X-Shopify-Access-Token' => $api_token, 
                                        'Content-Type' => 'application/json'] )
                        ->post( $url, [
                            "location_id"          => $warehouse_id, 
                            "inventory_item_id"    => $shopify_product_id,
                            "available" => $shopify_product_quantity 
                        ]);

        return $response->json();
    }

    public static function connect_item_to_location( $api_key, $api_password , $api_token , $store_name, $inventory_product_id, $warehouse_id ){

        $api_version = API_VERSION;
        $url ='https://'. $store_name .'.myshopify.com/admin/api/' . $api_version . '/inventory_levels/connect.json';

        $response = Http::withBasicAuth( $api_key, $api_password)
                        ->withHeaders( ['X-Shopify-Access-Token' => $api_token, 
                                        'Content-Type' => 'application/json'] )
                        ->post( $url, [array( 
                            "location_id"          => $warehouse_id, 
                            "inventory_item_id"    => $inventory_product_id,  
                            "available"            => 100,
                        )]);

        return $response->json();
    }




}

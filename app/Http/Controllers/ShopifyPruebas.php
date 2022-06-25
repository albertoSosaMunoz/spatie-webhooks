<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\ShopifyController;
use Illuminate\Http\Request;
class ShopifyPruebas extends Controller
{
    public static function run(){
        $api_key      = 'aa21604e63da4bbc9bf2db36d59e413b';
        $api_password = '4bb128fea4f0dbf29efde6073d21dfd0';
        $api_token    ='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';
        $store_name   = 'albertomunozmunoz';
        $module       = 'products';
        
        $response =ShopifyController::get( $api_key, $api_password, $api_token, $store_name, $module);

        //convierto a formato shopify
        $shopify_product = ShopifyPruebas::shopify_product();
        //creo el nuevo producto en shopify
        $response = ShopifyController::post($api_key, $api_password , $api_token , $store_name, $shopify_product, 'products' );        
        print_r($response);
        //guardo id de inventario del producto
        $product_inventory_level_id = $response['product']['variants'][0]['inventory_item_id'];
        //obtengo lista de location donde pueden almacenarse los productos        
        $response = ShopifyController::get($api_key, $api_password , $api_token , $store_name , 'locations' );
        //obtengo el id del warehouse donde quiero almacenar el producto
        $warehouse_id = $response['locations'][0]['id'];
        //conecto la id del producto con la id de la location donde quiero que se guarde el inventario
        $response = ShopifyController::connect_item_to_location($api_key, $api_password, $api_token, $store_name, $product_inventory_level_id, $warehouse_id);
        //con la id del producto y del almacen, cambio la cantidad         
        $response = ShopifyController::set_item_quantity( $api_key, $api_password , $api_token , $store_name, $product_inventory_level_id, $warehouse_id, 10 );
        dd($response);
        //print_r($img_base64);       
        
    }

    public static function shopify_product(){

        $img_url = 'https://i.pinimg.com/736x/c5/2c/9f/c52c9f9ec22ce0fb784db9cdfa73dc36.jpg';
        $img_name = explode( '/', $img_url );    
        $img_name = end($img_name);        
        $product_img = file_get_contents( $img_url );
        $img_base64 = base64_encode( $product_img );

        $shopify_product['images'][] = array ( 'attachment' => $img_base64 );
        $shopify_product['title'] = 'producto de prueba';
        $shopify_product['body_html']= 'esto es un producto de prueba';  
        $shopify_product['variants'][] = array (
            'title' => 'producto de prueba',
            'price' => '10.5',
            'taxable' => true,
            'barcode' => '12345678B',
            'inventory_management' => 'shopify'
        );

        return $shopify_product;
    }
}


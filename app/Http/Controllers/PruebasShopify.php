<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\AsanaController;
use App\Http\Controllers\API\ShopifyController;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\MagicConst\Line;

class PruebasShopify extends Controller
{
    public static function generate_asana_tasks(){

        $conditions         = PruebasShopify::asana_task_conditions();
        $asana_task_array = [];
        $asana_task_name    = false;
        
        /*foreach( $params['orders'] as $orders_array){
            foreach($orders_array['line_items'] as $line_item){
            $asana_task_name = 'PEDIDO - ' . $orders_array['number'];
            if( ! $asana_condition_name = PruebasShopify::create_asana_task_name($conditions, $line_item , $asana_task_name) ){
                continue;
            }             
            $asana_task_name           .= $asana_condition_name;
            
            $asana_task_array['name']   = $asana_task_name;
            $asana_task_array['notes']  = PruebasShopify::generate_asana_task_body($orders_array);
            }            
        }*/

        /*$project_id = '1202190919503073';
        $api_key = '1/491610466167065:e3b8f00b6601a197c8c3f9c40941a0d6';
        
        $response = AsanaController::get_project_tasks_names($api_key, $project_id);
        $asana_task_to_delete= [];
        $order_number = '#47320';

        if( isset ($response['data'] ) && ! empty( $response['data'] ) ) {
            foreach( $response['data'] as $asana_task){                
                print_r( strpos($asana_task['name'],  $order_number ));
                if( false !== strpos( $asana_task['name'], $order_number ) ){
                    $asana_task_to_delete['gid'][] = $asana_task['gid'];
                }

            }
        }
        print_r($asana_task_to_delete);*/

        /*$shipment_type              =  $single_order['shipping_lines'][0]['title']    ?? 'CLASE DE ENVIO NO SELECCIONADA';
		$shipping_address_name      =  $single_order['shipping_address']['name']      ?? 'NOMBRE DESTINATARIO NO INTRODUCIDO';
		$shipping_address_last_name =  $single_order['shipping_address']['last_name'] ?? 'APELLIDOS DESTINATARIO NO INTRODUCIDOS';
		$shipping_address           =  $single_order['shipping_address']['address1']  ?? 'DIRECCIÓN DE ENVIO NO INTRODUCIDA';
		$shipping_address_city      =  $single_order['shipping_address']['city']      ?? 'CIUDAD NO INTRODUCIDA';
		$shipping_address_province  =  $single_order['shipping_address']['province']  ?? 'PROVINCIA NO INTRODUCIDA';
		$shipping_address_country   =  $single_order['shipping_address']['country']   ?? 'PAÍS NO INTRODUCIDO';
		$shipping_address_zip       =  $single_order['shipping_address']['zip']       ?? 'CODIGO POSTAL NO INTRODUCIDO';
		$customer_first_name        =  $single_order['customer']['first_name']        ?? 'NOMBRE NO INTRODUCIDO' ;
		$customer_last_name         =  $single_order['customer']['last_name']         ?? 'APELLIDOS NO INTRODUCIDOS';
		$customer_phone             =  $single_order['customer']['phone']             ?? 'NUMERO DE TELÉFONO NO INTRODUCIDO' ;
		$customer_email             =  $single_order['customer']['email']             ?? 'EMAIL NO INTRODUCIDO';
		$order_url                  =  isset( $single_order['id'])                     ? 'https://aina-barcelona.myshopify.com/admin/orders/' . $single_order['id'] : 'URL NO RECONOCIDA';
		$order_notes                =  $single_order['note']                          ?? 'NO HAY NOTAS' ;

		$asana_task_body  = 'DATOS DE ENVIO'            . "\n";
		$asana_task_body .= '----------------------'    . "\n";
		$asana_task_body .= 'Clase de envio : '         . $shipment_type . "\n";
		$asana_task_body .= 'Destinatario : '           . $shipping_address_name . ' ' . $shipping_address_last_name . "\n";
		$asana_task_body .= 'Direccion : '              . $shipping_address . "\n";
		$asana_task_body .= 'Ciudad : '                 . $shipping_address_city  . "\n";
		$asana_task_body .= 'Provincia : '              . $shipping_address_province  . "\n";
		$asana_task_body .= 'Pais : '                   . $shipping_address_country . "\n";
		$asana_task_body .= 'Codigo Postal : '          . $shipping_address_zip . "\n";
		$asana_task_body .= 'DATOS DE CONTACTO'         . "\n";
		$asana_task_body .= '----------------------'    . "\n";
		$asana_task_body .= 'Nombre : '                 . $customer_first_name . ' ' . $customer_last_name . "\n";
		$asana_task_body .= 'Email : '                  . $customer_email . "\n";
		$asana_task_body .= 'Telefono : '               . $customer_phone . "\n";*/

    date_default_timezone_set('Europe/Madrid');
       $date   = now();
       $gmdate = gmdate($date);

       $date = strtotime($date);
       $gmdate = strtotime($gmdate);
       print_r ("date :" . $date . "<------>" . $gmdate . " : gmdate");



    }

    public static function create_asana_task_name($conditions, $line_item){        

        foreach($conditions as $key => $value){     
            $asana_condition_name = '';
            switch($key){
                case 'product_id':
                    //id del producto grabado talla
                    if( in_array($line_item['product_id'],$value)){
                        //nombre del producto
                        $asana_condition_name .= $line_item['name'] . ' - ';
                        //cantidad
                        $asana_condition_name .= $line_item['quantity'] . ' - '; 
                        return $asana_condition_name;                       
                    }
                    break;
                case 'product_properties':                    
                     //nombre de la condicion
                    if( 'paco' == $asana_condition_name){

                        $asana_condition_name .= 'Product Properties' . ' - ';
                        //nombre del producto
                        $asana_condition_name .= $line_item['name'] . ' - ';
                        //cantidad
                        $asana_condition_name .= $line_item['quantity'] . ' - '; 
                        return $asana_condition_name;       
                    }
                    break;
                case 'product_tag':
                    if( in_array ( $value[0], PruebasShopify::get_product_tags_by_id( $line_item['product_id'] )  ) ){

                        return "encontrado fabricacionasana";
                    }     
                    break;
           }           
        }              
    }


    public static function generate_asana_task_body($single_order){

        //dd($single_order);
        $asana_task_body  = 'DATOS DE ENVIO' . "\n";
        $asana_task_body .= '----------------------'    . "\n\n";
        $asana_task_body .= 'Compañia de envio : ' . $single_order['shipping_address']['company'] . "\n";
        $asana_task_body .= 'Clase de envio : '    . $single_order['shipping_lines'][0]['title'] . "\n";
        $asana_task_body .= 'Destinatario : '      . $single_order['shipping_address']['name'] . ' ' . $single_order['shipping_address']['last_name'] . "\n";
        $asana_task_body .= 'Direccion : '         . $single_order['shipping_address']['address1'] . "\n";
        $asana_task_body .= 'Ciudad : '            . $single_order['shipping_address']['city'] . "\n";
        $asana_task_body .= 'Provincia : '         . $single_order['shipping_address']['province'] . "\n";
        $asana_task_body .= 'Pais : '              . $single_order['shipping_address']['country'] . "\n";
        $asana_task_body .= 'Codigo Postal : '     . $single_order['shipping_address']['zip'] . "\n\n";
        $asana_task_body .= 'DATOS DE CONTACTO'    . "\n";
        $asana_task_body .= '----------------------'    . "\n\n";
        $asana_task_body .= 'Nombre : '             . $single_order['customer']['first_name'] . ' ' . $single_order['customer']['last_name'] . "\n";
        $asana_task_body .= 'Email : '             . $single_order['customer']['email'] . "\n";
        $asana_task_body .= 'Telefono : '          . $single_order['customer']['phone'] . "\n";
        $asana_task_body .= 'URL Pedido : '        . $single_order['order_status_url'] . "\n";
        $asana_task_body .= 'NOTA IMPORTANTE'      . "\n";
        $asana_task_body .= '----------------------'    . "\n\n";
        
        $asana_task_body .= ''                     . "\n";
         
        return $asana_task_body;
        
    }

    public static function asana_task_conditions(){
            //condiciones individuales para cada tipo de tarea Asana
        $create_tasks_conditions = [    'product_properties'  => array( 'Producto', 'Texto' ),
                                        'product_id'          => array( '78803211967292922' ),
                                        'product_tag'         => array( 'fabricacionasana'  ),
                                    ];
        
        return $create_tasks_conditions;

    }

    public static function get_product_tags_by_id($product_id){
        $tags_array = ['fabricacionasana'];
        return $tags_array;
    }

    public static function example_array(){

        return json_decode('{"id":820982911946154508,"email":"jon@doe.ca","closed_at":null,"created_at":"2022-04-05T16:54:56+02:00","updated_at":"2022-04-05T16:54:56+02:00","number":234,"note":null,"token":"123456abcd","gateway":null,"test":true,"total_price":"254.98","subtotal_price":"244.98","total_weight":0,"total_tax":"0.00","taxes_included":false,"currency":"EUR","financial_status":"voided","confirmed":false,"total_discounts":"5.00","total_line_items_price":"249.98","cart_token":null,"buyer_accepts_marketing":true,"name":"#9999","referring_site":null,"landing_site":null,"cancelled_at":"2022-04-05T16:54:56+02:00","cancel_reason":"customer","total_price_usd":null,"checkout_token":null,"reference":null,"user_id":null,"location_id":null,"source_identifier":null,"source_url":null,"processed_at":null,"device_id":null,"phone":null,"customer_locale":"es","app_id":null,"browser_ip":null,"landing_site_ref":null,"order_number":1234,"discount_applications":[{"type":"manual","value":"5.0","value_type":"fixed_amount","allocation_method":"each","target_selection":"explicit","target_type":"line_item","description":"Discount","title":"Discount"}],"discount_codes":[],"note_attributes":[],"payment_gateway_names":["visa","bogus"],"processing_method":"","checkout_id":null,"source_name":"web","fulfillment_status":"pending","tax_lines":[],"tags":"","contact_email":"jon@doe.ca","order_status_url":"https:\/\/alberto-munoz-prueba1.myshopify.com\/64062030073\/orders\/123456abcd\/authenticate?key=abcdefg","presentment_currency":"EUR","total_line_items_price_set":{"shop_money":{"amount":"249.98","currency_code":"EUR"},"presentment_money":{"amount":"249.98","currency_code":"EUR"}},"total_discounts_set":{"shop_money":{"amount":"5.00","currency_code":"EUR"},"presentment_money":{"amount":"5.00","currency_code":"EUR"}},"total_shipping_price_set":{"shop_money":{"amount":"10.00","currency_code":"EUR"},"presentment_money":{"amount":"10.00","currency_code":"EUR"}},"subtotal_price_set":{"shop_money":{"amount":"244.98","currency_code":"EUR"},"presentment_money":{"amount":"244.98","currency_code":"EUR"}},"total_price_set":{"shop_money":{"amount":"254.98","currency_code":"EUR"},"presentment_money":{"amount":"254.98","currency_code":"EUR"}},"total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"line_items":[{"id":487817672276298554,"variant_id":null,"title":"Aviator sunglasses","quantity":1,"sku":"SKU2006-001","variant_title":null,"vendor":null,"fulfillment_service":"manual","product_id":78803211967292922,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"Grabado Extra","variant_inventory_management":null,"properties":[],"product_exists":true,"fulfillable_quantity":1,"grams":100,"price":"89.99","total_discount":"0.00","fulfillment_status":null,"price_set":{"shop_money":{"amount":"89.99","currency_code":"EUR"},"presentment_money":{"amount":"89.99","currency_code":"EUR"}},"total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"EUR"},"presentment_money":{"amount":"0.00","currency_code":"EUR"}},"discount_allocations":[],"duties":[],"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/487817672276298554","tax_lines":[]},{"id":976318377106520349,"variant_id":null,"title":"Mid-century lounger","quantity":1,"sku":"SKU2006-020","variant_title":null,"vendor":null,"fulfillment_service":"manual","product_id":788032119674292922,"requires_shipping":true,"taxable":true,"gift_card":false,"name":"Mid-century lounger","variant_inventory_management":null,"properties":[],"product_exists":true,"fulfillable_quantity":1,"grams":1000,"price":"159.99","total_discount":"5.00","fulfillment_status":null,"price_set":{"shop_money":{"amount":"159.99","currency_code":"EUR"},"presentment_money":{"amount":"159.99","currency_code":"EUR"}},"total_discount_set":{"shop_money":{"amount":"5.00","currency_code":"EUR"},"presentment_money":{"amount":"5.00","currency_code":"EUR"}},"discount_allocations":[{"amount":"5.00","discount_application_index":0,"amount_set":{"shop_money":{"amount":"5.00","currency_code":"EUR"},"presentment_money":{"amount":"5.00","currency_code":"EUR"}}}],"duties":[],"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/976318377106520349","tax_lines":[]}],"fulfillments":[],"refunds":[],"total_tip_received":"0.0","original_total_duties_set":null,"current_total_duties_set":null,"payment_terms":null,"admin_graphql_api_id":"gid:\/\/shopify\/Order\/820982911946154508","shipping_lines":[{"id":271878346596884015,"title":"Generic Shipping","price":"10.00","code":null,"source":"shopify","phone":null,"requested_fulfillment_service_id":null,"delivery_category":null,"carrier_identifier":null,"discounted_price":"10.00","price_set":{"shop_money":{"amount":"10.00","currency_code":"EUR"},"presentment_money":{"amount":"10.00","currency_code":"EUR"}},"discounted_price_set":{"shop_money":{"amount":"10.00","currency_code":"EUR"},"presentment_money":{"amount":"10.00","currency_code":"EUR"}},"discount_allocations":[],"tax_lines":[]}],"billing_address":{"first_name":"Bob","address1":"123 Billing Street","phone":"555-555-BILL","city":"Billtown","zip":"K2P0B0","province":"Kentucky","country":"United States","last_name":"Biller","address2":null,"company":"My Company","latitude":null,"longitude":null,"name":"Bob Biller","country_code":"US","province_code":"KY"},"shipping_address":{"first_name":"Steve","address1":"123 Shipping Street","phone":"555-555-SHIP","city":"Shippington","zip":"40003","province":"Kentucky","country":"United States","last_name":"Shipper","address2":null,"company":"Shipping Company","latitude":null,"longitude":null,"name":"Steve Shipper","country_code":"US","province_code":"KY"},"customer":{"id":115310627314723954,"email":"john@test.com","accepts_marketing":false,"created_at":null,"updated_at":null,"first_name":"John","last_name":"Smith","orders_count":0,"state":"disabled","total_spent":"0.00","last_order_id":null,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"phone":null,"tags":"fabricacionasana","last_order_name":null,"currency":"EUR","accepts_marketing_updated_at":null,"marketing_opt_in_level":null,"email_marketing_consent":{"state":"not_subscribed","opt_in_level":null,"consent_updated_at":null},"sms_marketing_consent":null,"admin_graphql_api_id":"gid:\/\/shopify\/Customer\/115310627314723954","default_address":{"id":715243470612851245,"customer_id":115310627314723954,"first_name":null,"last_name":null,"company":null,"address1":"123 Elm St.","address2":null,"city":"Ottawa","province":"Ontario","country":"Canada","zip":"K2H7A8","phone":"123-123-1234","name":"","province_code":"ON","country_code":"CA","country_name":"Canada","default":true}}}', true);

    }

    public static function convert_shopify_to_asana_task(){

    }

}

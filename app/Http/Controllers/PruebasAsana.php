<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OutOfRangeException;

class PruebasAsana extends Controller
{
    public static function run(){

        PruebasAsana::pruebas();

    }


    public static function pruebas(){

        $shopify_data = [];
        // api key pruebas
        $shopify_data['api_key']      = '816a266a12c6e8d66f182246d8711b54';
        $shopify_data['api_password'] = '816a266a12c6e8d66f182246d8711b54';
        $shopify_data['api_token']    = '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';
        $shopify_data['store_name']   = 'albertomunozsosa';
        // api key pruebas

        $url = 'https://'.$shopify_data['store_name'].'.myshopify.com/admin/api/2022-04/graphql.json ';
       echo($url);
       $query = '{
        productVariants(first:10,query:"sku:12345678A"){
          edges{
            node{
              id
              sku
            }
          }
        }
          
      }
      ';
       
        /*$result = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => $shopify_data['api_token']
        ])->post( $url ,  [ "query"  => json_encode($query)] );

        print_r($result->json());
*/
  
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $request_header[]="Content-Type: application/json";
        $request_header[]='X-Shopify-Access-Token: ' . $shopify_data['api_token'];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_header);
        curl_setopt($curl, CURLOPT_POST, TRUE);        
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($query));

        $response = curl_exec($curl);
        $error_number = curl_errno($curl);
        $error_message = curl_error($curl);

        if($error_number){
            echo $error_message;
        }else{
           
            $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response,2);

            $headers = array();
            $header_data = explode ("\n", $response[0] );
            $headers['status'] = $header_data[0];
            array_shift($header_data);
            foreach($header_data as $part){
                $h = explode(":", $part);
                $header[trim($h[0])] = trim($h[1]);
            }

            print_r($response);
        }




    }
}

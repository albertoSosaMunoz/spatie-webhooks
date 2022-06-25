<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;


class AsanaController extends Controller
{
    public static function get_project_tasks_names( $apikey, $project_id,$next_page_uri=false,$limit= 10, ){

		if($next_page_uri)
		 	$url = $next_page_uri;
		else
        	$url = 'https://app.asana.com/api/1.0/projects/' . $project_id . "/tasks?limit=" . $limit;


		if ( ! empty( $query ) ) {
			$url .= '?' . http_build_query( $query,'','&' );
		}
		$response = Http::withHeaders([
			'Content-type' => 'application/json',
			'Authorization' => 'Bearer ' . $apikey,
		])->get( $url );

		return $response->json();
		
    }


}

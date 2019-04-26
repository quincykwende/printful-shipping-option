<?php

/** 
 * This class controls all access to the API
 * Based on the assignment this file will handle only POST Request
 *
 * @author Quincy Kwende <quincykwende[at]gmail.com>
 *
*/ 

namespace PrintfulTasks;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class Request{

	//Construct
	public function __construct()
    {
        $config = include_once "./config/config.php";

        //get authorisation string
        $this->authorisation = $this->authorizationString($config['api_key']);

        //instantiate Guzzle Client
        $this->client = new Client([
		    'base_uri' => $config['base_url'],
		    'timeout'  => 2.0,
		]);
    }

    /**
     * Returns the authorisation string
     * Basic base64 encode apikey
     *
     * @param  string  $uri
     * @param  json $data 
     * @param  bool  $authenticate
     * @return object
     */
    public function authorizationString($api_key){
    	return "Basic ". base64_encode($api_key);
    }

    /**
     * Handles POST Request via GUZZLE
     * Return json_decoded data
     * uses json -- post json
     *
     * @param  string  $uri
     * @param  json $data 
     * @param  bool  $authenticate
     * @return object
     */
    public function post($uri, $data, $authenticate=false){

		try{

            $response = $this->client->request('PUT', $uri, 
                [
	               'body' => $data,
	               'headers' => [
        				          'Content-Type' => 'application/json',
        				          'Authorization' => $this->authorisation,
        				        ]
	   		    ]
            );

            $response = json_decode($response->getBody()->getContents());

            $results = [
            			'status' => '200',
	    				'data' => $response
            		];

	    	return json_decode(json_encode($results));
        }
        catch (\GuzzleHttp\Exception\RequestException $e) {

            var_dump($response);

            $response = json_decode($e->getResponse());

            $results = [
            			'status' => '400',
	    				'data' => $response
            		];

            return json_decode(json_encode($results));
        }

	}
	

}
<?php

/** 
 * This class controls all access to the API
 * Based on the assignment this file will handle only POST Request
 *
 * @author Quincy Kwende <quincykwende[at]gmail.com>
 *
*/ 

namespace PrintfulTasks;
use PrintfulCache\FileCache;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use PrintfulTasks\Exception\PrintfulException;


class Request{

	//Construct
	public function __construct()
    {
        //load config
        $config = include_once "./config/config.php";

        if($config['api_key'] == ''){
            throw new PrintfulException("Please define your api_key in config/config.php");
        }

        //get authorisation string
        $this->authorisation = $this->authorizationString($config['api_key']);

        //instantiate Guzzle Client
        $this->client = new Client([
		    'base_uri' => $config['base_uri'],
		    'timeout'  => 2.0,
		]);

        //instantiate cache
        $this->cache = new FileCache();
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
        /*
        * check if request is already in cache then return cached request
        * Build cache key from uri + data; key is supposed to be string
        */
        $key = serialize($uri.$data);

        if($this->cache->get($key) != null){
            //get reponse from cache
            $response = $this->cache->get($key);  

        }else{
            try{
                $response = $this->client->post($uri, 
                    [
                       'headers' => [
                                      'Content-Type' => 'application/json',
                                      'Accept' => 'application/json',
                                      'Authorization' => $this->authorisation,
                                    ],
                        'body' => $data,
                    ]
                );
                $response = json_decode($response->getBody()->getContents());
            }
            catch (\GuzzleHttp\Exception\RequestException $e) {

                $response = json_decode($e->getResponse()->getBody()->getContents());

                /*$results = [
                                'status' => '400',
                                'data' => $response
                        ];*/

                return json_decode(json_encode($response));
            }

            //set result in cache for five minutes --- function takes duration in seconds
            $duration = 5 * 60;
            $this->cache->set($key, $response, $duration);
        }

        //build result array
        //$results = ['status' => '200', 'data' => $response];

	    return json_decode(json_encode($response));
	}
	

}
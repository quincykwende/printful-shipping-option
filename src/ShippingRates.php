<?php

/** 
 * This class connects to the Printful Ship Rates API 
 * and retrieves the list of available shipping
 *
 * @author Quincy Kwende <quincykwende[at]gmail.com>
 *
*/ 

namespace PrintfulTasks;
use PrintfulTasks\Request;


class ShippingRates{

    public function getRates($data){

    	$uri = "shipping/rates";

    	$json_data = json_encode($data);

    	$request = new Request();

    	return $request->post($uri, $json_data, true);
    }

}
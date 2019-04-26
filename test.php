<?php

//Running Test here

//autoload
require_once __DIR__.'/vendor/autoload.php';

use PrintfulTasks\ShippingRates;

$shippment_rates = new ShippingRates();

//build data
$product_variant_id = "7679";
$quantity = 2;
$address = "11025 Westlake Dr, Charlotte, North Carolina, 28273";
$country_code = "US";
$city = "Charlotte";
$zip = "28273";

//build JSON
$data = [
		"recipient" => [
			"address1" => $address,
			"city"=>  $city,
			"country_code" => $country_code,
			"zip" => $zip
		],
		"items" => [
			[
				"variant_id" => $product_variant_id,
				"quantity" => $quantity,
			]
		]
	];

	//echo json_encode($data);

	var_dump($shippment_rates->getRates($data));


exit;

<?php

	//Running Test here

	//autoload
	require_once __DIR__.'/vendor/autoload.php';

	use PrintfulTasks\ShippingRates;

	$shippment_rates = new ShippingRates();

	//build data
	$product_variant_id = "7679";
	$quantity = 2;
	$address = "11025 Westlake Dr";
	$country_code = "US";
	$city = "Charlotte";
	$zip = "28273";

    //build data
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

	$results = $shippment_rates->getRates($data);

	echo "<pre>";
	var_dump($results);
	echo "</pre>";
# Printful: Available Shipping Options
Used the "quincykwende/printfulcache and guzzlehttp/guzzle" composer package to retrive the list of available shipping options from Printful's Shipping Rate API. 

This project uses 2 composer plugin
	- quincykwende/printfulcache; This composer package was made for the purpose of this task
    - guzzlehttp/guzzle


## Folder Structure
	- printful-shipping-option (root)
		- cache
		- config
			- config.php
			- printful-cache.php (publish the quincykwende/printfulcache config file here)
		- src
			- Request.php
			- ShippingRates.php
		- README.md
		- test.php
		- .composer.json


## Requirement
- Tested on PHP 7.1.23 ( NTS )


## Installation
```	
	git clone https://github.com/quincykwende/printful-shipping-option.git
	composer update

```
- Enter your api_key in the config/config.php
- Create your cache folder anywhere and update the path in config/config.php
- The give write access to this directory
```sudo chmod -R 777 cache```
NB: My cache folder is in the root directory. 


## Test
```	
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

	print "<pre>";
	var_dump($results);
	print "</pre>";

```
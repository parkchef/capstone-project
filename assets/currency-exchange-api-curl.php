<?php
$req_url = 'https://api.exchangerate-api.com/v4/latest/MYR';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if (false !== $response_json) {

    // Try/catch for json_decode operation
    try {

        // Decoding
        $response_object = json_decode($response_json);

        // YOUR APPLICATION CODE HERE, e.g.
        $base_price = 12; // Your price in USD
        $EUR_price = round(($base_price * $response_object->rates->USD), 2);
        echo $EUR_price;
    } catch (Exception $e) {
        // Handle JSON parse error...
    }
}

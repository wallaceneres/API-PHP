<?php

function api_request($endpoint, $method = 'GET', $variables = [])
{

    //initiate the curl client
    $client = curl_init();

    $api_username = API_USERNAME;
    $api_password = API_PASSWORD;

    $headers = array(
        'Contet-Type: application/json',
        'Authorization: Basic ' . base64_encode("$api_username:$api_password")
    );
    
    curl_setopt($client, CURLOPT_HTTPHEADER, $headers);
    //returns the result as a string
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

    //defines the url
    $url = API_BASE_URL;

    //if request is GET
    if($method == 'GET')
    {
        $url .= "?endpoint=$endpoint";
        if(!empty($variables))
        {
            $url .= "&" . http_build_query($variables);
        }
    }

    //if request is POST

    if($method == 'POST')
    {
        $variables = array_merge(['endpoint' => $endpoint], $variables);
        curl_setopt($client, CURLOPT_POSTFIELDS, $variables);
    }

    curl_setopt($client, CURLOPT_URL, $url);

    $response = curl_exec($client);

    curl_close($client);

    return json_decode($response, true);

}
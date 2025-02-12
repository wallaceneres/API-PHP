<?php

//dependencies

require_once(dirname(__FILE__) . '/inc/config.php');
require_once(dirname(__FILE__) . '/inc/api_response.php');
require_once(dirname(__FILE__) . '/inc/api_logic.php');
require_once(dirname(__FILE__) . '/inc/database.php');

//instanciate the api_classe

$api_response = new api_response();

$user = $_SERVER['PHP_AUTH_USER'] ?? null;
$password = $_SERVER['PHP_AUTH_PW'] ?? null;

if(!$api_response->isUserAuthorized($user, $password))
{
    $api_response->api_request_error('User not Authorized');
}

// check if method is valid

if(!$api_response->check_method($_SERVER['REQUEST_METHOD']))
{
    //send error response
    $api_response->api_request_error('Invalid request method.');
}

//set request method

$api_response->set_method($_SERVER['REQUEST_METHOD']);

$params = null;

$endpoint = isset($_GET['endpoint']) && !empty($_GET['endpoint']) ? $_GET['endpoint'] : 'default';

if($api_response->get_method() == 'GET')
{
    $api_response->set_endpoint($endpoint);
    $params = $_GET;
}elseif($api_response->get_method() == 'POST')
{
    $api_response->set_endpoint($_POST['endpoint']);
    $params = $_POST;
}

$api_logic = new api_logic($api_response->get_endpoint(), $params);

//check if endpoint exists
if(!$api_logic->endpoint_exists())
{
    $api_response->api_request_error('Inexistent endpoint;' . $api_response->get_endpoint());
}

//request the api logic

$result = $api_logic->{$api_response->get_endpoint()}();
$api_response->add_do_data('data', $result);

//$api_response->send_api_status();

$api_response->send_response();
    

<?php
error_reporting(0);
ini_set('display_errors', 0);
require $_SERVER["DOCUMENT_ROOT"]."/restapi/init.php";
use App\libraries\Request;
use App\libraries\Rest;
use App\models\Customers;


header("Access-Control-Allow-Origin: development.paidba.com");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
	
	$headers = getallheaders();
	$cb = [];
	$request = new Request();

	$rest = new Rest($headers, $request->get);
	$rest->basicValidation();
	$code = 200;
	$response = "OK";
	if(!$request->get){
		$code = 405;
		$response = "Error";
		$rest->setResponse($code, $response, 'Method not allowed');
	}
	
	$payload = $_GET;
	$id = isset($payload['id']) ? rawurlencode(trim($payload['id'])) : false;

	if(!$id){
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : id";
	}else{

		$customer = new Customers();
		$customer->id = $id;
		$customers_data = $customer->getCustomer();
		$message = "success";
		$cb = (array) $customers_data;

	}
	$rest->setResponse($code, $response, $message, $cb);	

} catch (\Exception $e) {
	$rest->setResponse(500, "Error", "Internal server error");
}



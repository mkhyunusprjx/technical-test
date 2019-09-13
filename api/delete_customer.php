<?php
error_reporting(0);
ini_set('display_errors', 0);
require $_SERVER["DOCUMENT_ROOT"]."/restapi/init.php";
use App\libraries\Request;
use App\libraries\Rest;
use App\models\Customers;



header("Access-Control-Allow-Origin: development.paidba.com");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
	
	$headers = getallheaders();

	$request = new Request();
	$rest = new Rest($headers);
	$rest->basicValidation();
	$code = 200;
	$response = "OK";
	if(!$request->delete){
		$code = 405;
		$response = "Error";
		$rest->setResponse($code, $response, 'Method not allowed');
	}

	$body = file_get_contents("php://input");
	$payload = json_decode($body, true);
	$id = isset($payload['id']) ? rawurlencode(trim($payload['id'])) : '';

	$cb = [];

	if(!$id){
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : id";
	}else{
		$customer = new Customers();
		$customer->id = $id;
		$deleteCustomer = false;
		$deleteCustomer = $customer->deleteCustomer();
		if($deleteCustomer){
			$message = "Delete success";
		}else{
			$code = 500;
			$response = "Error";
			$message = "Internal server error";
		}	
	}

	$rest->setResponse($code, $response, $message, $cb);	

} catch (\Exception $e) {
	$rest->setResponse($code, "Error", "Internal server error");
}



<?php
error_reporting(0);
ini_set('display_errors', 0);
require $_SERVER["DOCUMENT_ROOT"]."/restapi/init.php";
use App\libraries\Request;
use App\libraries\Rest;
use App\models\Customers;



header("Access-Control-Allow-Origin: development.paidba.com");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
	
	$headers = getallheaders();

	$request = new Request();
	$rest = new Rest($headers);
	$rest->basicValidation();
	if(!$request->post){
		$rest->setResponse(405, "Error", 'Method not allowed');
	}

	$body = file_get_contents("php://input");
	$payload = json_decode($body, true);
	$name = isset($payload['name']) ? trim($payload['name']) : '';
	$email = isset($payload['email']) ? trim($payload['email']) : '';
	$password = isset($payload['password']) ? trim($payload['password']) : '';
	$gender = isset($payload['gender']) ? trim($payload['gender']) : '';
	$is_married = isset($payload['is_married']) ? trim($payload['is_married']) : '';
	$address = isset($payload['address']) ? trim($payload['address']) : '';
	// $callback = [];
	$code = 200;
	$response = "OK";
	$cb = [];
	if(!$name){
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : name";
	}else if(!$email){	
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : email";

	}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$code = 400;
		$response = "Failed";
		$message = "Email not valid";
	}else if(!$password){
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : password";
	}else if(!$gender){
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : gender";
	} else if(!$is_married){
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : is_married";
	}else if(!$address){
		$code = 400;
		$response = "Failed";
		$message = "The request is missing a required parameter : address";
	}else{
		$message = "Create customer success";

		$customer = new Customers();
		$customer->name = $name;
		$customer->email = $email;
		$customer->password = $password;
		$customer->gender = $gender;
		$customer->is_married = $is_married;
		$customer->address = $address;
		$checkEmail = $customer->checkEmail($customer->email);
		$createCustomer = [];
		if($checkEmail){
			$code = 409;
			$response = "Failed";
			$message = "Email already exist";
		}else{
			$createCustomer = $customer->createCustomer();
		}
		$cb = $createCustomer;
	}

	$rest->setResponse($code, $response, $message, $cb);	

} catch (\Exception $e) {
	$rest->setResponse(500, "Error", "Internal server error");
}



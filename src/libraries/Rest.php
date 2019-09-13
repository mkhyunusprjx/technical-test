<?php
namespace app\libraries;

use App\models\User;
use App\database\DB;
use \Firebase\JWT\JWT;

Class Rest{

	private $request;
	private $headers;
	private $auth;
	public $client_data;

	public function __construct($headers, $get = false){
		$this->headers = $headers;
		if(!$get){
			
			if($headers['Content-Type'] !="application/json"){
				$this->setResponse(406, "Error", "Not Acceptable");
			}
		}
	}
	public function header()
	{
		
		return $this->request->header;
	}

	public function basicValidation()
	{
		$authorization = isset($this->headers['Authorization']) ? $this->headers['Authorization'] : false ;

		list($auth) = sscanf( $authorization, 'Basic %s');
		$auth_string = base64_decode($auth);
		$auth_array = explode(":", $auth_string);
		if(count($auth_array) < 2)
		{
			$this->setResponse(401, "Error", "Unauthorized");
		}

		require ROOT."config/config.php";
		if($auth_array[0] != API_ID || $auth_array[1] != API_SECRET){
			$this->setResponse(401, "Error", "Unauthorized");
		}

	}

	public function bearerValidation()
	{
		$authorization = isset($this->request->header['Authorization']) ? $this->request->header['Authorization'] : false ;
		list($auth) = sscanf( $authorization, 'Bearer %s');
		$this->auth = $auth;
		return $this->auth;

	}

	

	public static function setResponse($error_code, $response_text,  $message =  'success', $callback = []){
		$response = [];
		switch ($error_code) {
			case 200:
				header("HTTP/1.1 200 OK");
				$response['status']['code'] = 200;
				break;
			
			case 400:
				header("HTTP/1.1 400 Bad Request");
				$response['status']['code'] = 400;
				break;
			case 401:
				header("HTTP/1.1 401 Unathorized client");
				$response['status']['code'] = 401;
				break;
			case 405:
				header("HTTP/1.1 405 Method Not Allowed");
				$response['status']['code'] = 405;
				break;
			case 406:
				header("HTTP/1.1 406 Not Acceptable");
				$response['status']['code'] = 406;
				break;
			case 409:
				header("HTTP/1.1 409 Conflict");
				$response['status']['code'] = 409;
				break;
			default:
				header("HTTP/1.1 500 Internal server error");
				$response['status']['code'] = 500;
				break;

		}
		$response['status']['response'] = $response_text;
		$response['status']['message'] = $message;
		$response['result'] = ($callback) ? $callback : new \stdClass() ;
		echo json_encode($response);
		exit(0);
	}

}


<?php
namespace App\libraries;

Class Request
{

	private static $_instance;
	private $request;
	public $header = [];
	public $post;
	public $put;
	public $delete;
	public $get;
	public $patch;
	public $copy;
	public $options;
	public $head;

	public function __construct()
	{
		$this->request = $_SERVER['REQUEST_METHOD'];
		$this->header = getallheaders();
		if($this->request == 'POST')
			$this->post = true;
		else if($this->request == 'GET')
			$this->get = true;
		else if($this->request == 'PUT')
			$this->put = true;
		else if($this->request == 'PATCH')
			$this->patch = true;
		else if($this->request == 'DELETE')
			$this->delete = true;
	}

	public static function init()
	{
		$instance = null;
		if(!$instance)
		{
			self::$_instance = new Request();
		}
		return self::$_instance;
	}
	
}

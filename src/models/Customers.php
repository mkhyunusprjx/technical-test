<?php
namespace App\models;
use App\database\DB;

Class Customers {

	public $id;
	public $name;
	public $email;
	public $password;
	public $gender;
	public $is_married;
	public $address;
	private $table = 'customers';

	public function __construct(){
		$this->db = DB::connect();
	}
	public function createCustomer()
	{
		try {
			$sql = "INSERT INTO ".$this->table."  (name, email,password, gender, is_married, address) 
					VALUES (:name, :email, :password, :gender, :is_married, :address)";
			$params = [
				':name' => $this->name,
				':email' => $this->email,
				':password' => sha1($this->password),
				':gender' => $this->gender,
				':is_married' => $this->is_married,
				':address' => $this->address,
			];
			$query = $this->db->prepare($sql);
			$cb = [];
			
			if($query->execute($params)){
				foreach ($params as $key => $value) {
					$index = str_replace(":", "", $key);
					$cb[$index] = $value;
				}	
			}	
			return $cb;
		} catch (\Exception $e) {
			print_r($e);die;
			return false;
		}
	}

	public function getCustomer(){
		try {
			$sql = "SELECT id, name, email,password, gender, is_married, address FROM ".$this->table." WHERE id=:id";
			$params = [":id" => $this->id];
			$query = $this->db->prepare($sql);
			$query->execute($params);
			$data = $query->fetch(\PDO::FETCH_OBJ);
			return $data;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	public function getCustomers(){
		try {
			$sql = "SELECT * FROM ".$this->table;
			$query = $this->db->prepare($sql);
			$query->execute();
			$data = $query->fetchAll(\PDO::FETCH_OBJ);
			return $data;
		} catch (\Exception $e) {
			print_r($e);die;
			return false;
		}
	}

	public function checkEmail($email, $id = false){
		try {
			$sql = "SELECT * FROM ".$this->table." WHERE email=:email";
			$params = [":email" => $email];
			if($id){
				$sql .=' AND id != :id';
				$params = array_merge($params, [":id" => $id]);
			}
			$query = $this->db->prepare($sql);
			 $query->execute($params);
			return $query->fetch(\PDO::FETCH_OBJ);
		} catch (\Exception $e) {
			return false;
		}
	}

	public function updateCustomer(){
		try {
			$sql = "UPDATE ".$this->table." SET name=:name, email=:email, gender=:gender, is_married=:is_married, address=:address";
			$params = [
				':id' => $this->id,
				':name' => $this->name,
				':email' => $this->email,
				':gender' => $this->gender,
				':is_married' => $this->is_married,
				':address' => $this->address,
			];

			if($this->password){
				$sql .= ", password=:password";
				$params = array_merge($params, [':password' => sha1($this->password)]);
			}

			$sql .=" WHERE id=:id";

			$cb = [];
			$query = $this->db->prepare($sql);
			if($query->execute($params)){
				foreach ($params as $key => $value) {
					$index = str_replace(":", "", $key);
					if($index != 'password'){
						$cb[$index] = $value;
					}
				}	
			}	
			return $cb;
		} catch (\Exception $e) {
			print_r($e);die;
			return false;
		}
	}
	public function deleteCustomer(){
		try {

			$sql = "DELETE FROM ".$this->table. " WHERE id=:id";
			$params = [
				':id' => $this->id
			];
			$query = $this->db->prepare($sql);
			return $query->execute($params);

		} catch (\Exception $e) {
			print_r($e);die;
			return false;
		}
	}


}
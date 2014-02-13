<?php

include_once("config.php");
include_once("data.php");

class session {

	function __construct() {
		$this->cookie_file = tempnam("/tmp", "rpc_session");
		$this->login();
	}
	
	function __destruct() {
		$this->logout();
		unlink($this->cookie_file);
	}
	
	function call($data) {
		$post_items = array();
		foreach ( $data as $key => $value) {
			array_push($post_items, urlencode($key).'='.urlencode($value));
		}
		$post_string = implode ('&', $post_items);
		$con = curl_init(config::$rpc_url);
		curl_setopt($con, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($con, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($con, CURLOPT_POST, 1);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($con, CURLOPT_COOKIEFILE, $this->cookie_file);
		curl_setopt($con, CURLOPT_COOKIEJAR, $this->cookie_file);
		curl_setopt($con, CURLOPT_POSTFIELDS, $post_string);
		$res = curl_exec($con);
		curl_close($con);
		return $res;
	}

	function login() {
		return $this->call(array(
			"action" => "login",
			"email" => config::$rpc_username,
			"passwd" => config::$rpc_password
		));
	}
	
	function logout() {
		return $this->call(array(
			"action" => "logout",
		));  
	}

	public function addUser($email) {
		return $this->call(array(
			"action" => "add",
			"email" => $email,
			"quiet" => config::$quiet,
			"list" => config::$rpc_mailinglist
		));    
	}
	
	public function delUser($email) {
		return $this->call(array(
			"action" => "del",
			"email" => $email,
			"quiet" => config::$quiet,
			"list" => config::$rpc_mailinglist
		));    
	}
	
	public function listUsers() {
		return preg_split('/\n/', $this->call(array(
			"action" => "dump",
			"format" => "light",
			"list" => config::$rpc_mailinglist
		)));
	}
  
}

class rpc {

	# adds a new user to the list.
	# argument is a data entry like in data.php
	# returns null on success, or an error string on error.
	public static function add($dataentry) {
		try {
			$session = new session();
			$session->addUser($dataentry->email);
			if (in_array($dataentry->email, $session->listUsers())) return null;
		} catch (Exception $ex) {}
		return "Failed to add entry to mailing list";
	}



	# removes a user from the list
	# argument is the user's email address
	# returns null on success, or an error string on error.
	public static function remove($email) {
		try {
			$session = new session();
			$session->delUser($email);
			if (!in_array($email, $session->listUsers())) return null;
		} catch (Exception $ex) {}
		return "Failed to remove entry from mailing list";
	}

}

?>
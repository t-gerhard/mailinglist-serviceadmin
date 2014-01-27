<?php

include_once("data.php");
include_once("sql.php");
include_once("rpc.php");

class library {

	# adds a new user to the list.
	# argument is a data entry like in data.php
	# returns null on success, or an error string on error.
	public static function add($dataentry) {

		# add data entry to SQL database. on error, return the error message
		$sql_res = sql::add($dataentry);
		if(!is_null($sql_res)) {
			return $sql_res;
		}

		# submit data entry to RPC. on error, remove the SQL entry and return the error code.
		$rpc_res = rpc::add($dataentry);
		if(!is_null($rpc_res)) {
			sql::remove($dataentry->email);
			return $rpc_res;
		}

		# if everything went well, nothing should be returned.
	}




	
	# removes a user from the list
	# argument is the user's email address
	# returns null on success, or an error string on error.
	public static function remove($email) {
		# first, remove email address from the rpc server.
		# on error, return the error message.
		$rpc_res = rpc::remove($email);
		if(!is_null($rpc_res)) {
			return $rpc_res;
		}

		# if the RPC call worked, now remove the sql entry. on error, return the error message.
		$sql_res = sql::remove($email);
		if(!is_null($sql_res)) {
			return $sql_res;
		}

		# if everything went fine, there is nothing to return.
	}







	# list all users
	# returns an array of entries like in data.php
	public static function list_entries() {
		# this does not need to use the RPC.
		# just forward this to the sql module.
		return sql::list_entries();
	}


}

?>

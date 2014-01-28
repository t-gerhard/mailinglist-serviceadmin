<?php
include_once("config.php");
include_once("data.php");

class sql {

	private static $db;
	
	private static function open_db() {
		
		$error_message = NULL;

		self::$db = new SQLite3(config::$sqlite_database);
		if($error_message != "") {
			return $error_message;
		}

		return "";
	}

	private static function close_db() {
		self::$db->close();
	}





	# adds a new user to the list.
	# argument is a data entry like in data.php
	# returns null on success, or an error string on error.
	public static function add($entry) {
		if(get_class($entry) == "entry") {
			self::open_db();
			
			$statement = self::$db->prepare("INSERT INTO '" . config::$sqlite_table . "' (email,fullname,title,status,faculty,project) 
											VALUES (:email,:fullname,:title,:status,:faculty,:project);");

			$statement->bindValue(":email", $entry->email, SQLITE3_TEXT);
			$statement->bindValue(":fullname", $entry->fullname, SQLITE3_TEXT);
			$statement->bindValue(":title", $entry->title, SQLITE3_TEXT);
			$statement->bindValue(":status", $entry->status, SQLITE3_TEXT);
			$statement->bindValue(":faculty", $entry->faculty, SQLITE3_TEXT);
			$statement->bindValue(":project", $entry->project, SQLITE3_TEXT);

			$statement->execute();

			self::close_db();	

		} else {
			return "SQL: Got the wrong attribute class";
		}

		return "";

	}
	

	# removes a user from the list
	# argument is the user's email address
	# returns null on success, or an error string on error.
	public static function remove($email) {
		if($email != "") {
			self::open_db();
			
			$statement = self::$db->prepare("DELETE FROM '" . config::$sqlite_table . "' 
				WHERE email = :email");

			$statement->bindValue(':email', $email, SQLITE3_TEXT);

			$statement->execute();
		

			self::close_db();	

		} else {
			return "SQL: Got no E-Mail Address to remove";
		}


		return "";
	}



	# list all users
	# returns an array of entries like in data.php
	public static function list_entries() {
			self::open_db();
			
			$statement = "SELECT * FROM '" . config::$sqlite_table . "';";
			
			$query = self::$db->query($statement);
			$res = array();
			while ($row = $query->fetchArray() ) {
				$res[] = new entry(
					$row['email'],
					$row['fullname'],
					$row['title'],
					$row['status'],
					$row['faculty'],
					$row['project']
				);
			}

			self::close_db();
			
			return $res;			
	}
}

?>

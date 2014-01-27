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

	public static function add($entry) {
		if(get_class($entry) == "entry") {
			self::open_db();
			
			$statement = self::$db->prepare("INSERT INTO '" . config::$sqlite_table . "' (email,fullname,title,status,faculty,project) 
											VALUES (:email,:fullname,:title,:status,:faculty,:project);");

			$statement->bindParam(":email", $entry->$email, SQLITE3_TEXT);
			$statement->bindParam(":fullname", $entry->$fullname, SQLITE3_TEXT);
			$statement->bindParam(":title", $entry->$title, SQLITE3_TEXT);
			$statement->bindParam(":status", $entry->$status, SQLITE3_TEXT);
			$statement->bindParam(":faculty", $entry->$faculty, SQLITE3_TEXT);
			$statement->bindParam(":project", $entry->$project, SQLITE3_TEXT);

			$error_message = NULL;
			if(!self::$db->exec($statement->execute(), $error_message)) {
				return $error_message;				
			}

			self::close_db();	

		} else {
			return "SQL: Got the wrong attribute class";
		}

		return "";

	}
	
	public static function remove($email) {
		if($email != "") {
			self::open_db();
			
			$statement = self::$db->prepare("DELETE FROM '" . config::$sqlite_table . "' 
				WHERE email = :email");

			$statement->bindValue(':email', $entry->email, SQLITE3_TEXT);

			if(!self::$db->exec($statement->execute(), $error_message)) {
				return $error_message;				
			}

			self::close_db();	

		} else {
			return "SQL: Got no E-Mail Address to remove";
		}


		return "";
	}

	public static function list_entry() {
			self::open_db();
			
			$statement = "SELECT * FROM '" . config::$sqlite_table . "';";
			
			$query = self::$db->query($statement);
			$return = $query->fetch_all();

			self::close_db();
			
			return $return;			
	}
}

?>

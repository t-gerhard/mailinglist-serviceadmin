<?php
include_once("config.php");
include_once("data.php");

class sql {

	private static $db;
	
	private static function open_db() {

		$error_message = NULL;

		self::$db = SQLite3::open ($sqlite_database, 0666, $error_message);
		if($error_message != "") {
			return $error_message;
		}

		return "";
	}

	private static function close_db() {
		SQLite3::close(self::$db);
	}

	public static function add($entry) {
		if(get_class($entry) == "entry") {
			self::open_db();
			
			$statement = self::$db->prepare("INSERT INTO '" . $sqlite_table . "' (email,fullname,title,status,faculty,project) 
											VALUES (:email,:fullname,:title,:status,:faculty,:project);");

			$statement->bindValue(':email', $entry->email, SQLITE3_TEXT);
			$statement->bindValue(':fullname', $entry->fullname, SQLITE3_TEXT);
			$statement->bindValue(':title', $entry->title, SQLITE3_TEXT);
			$statement->bindValue(':status', $entry->status, SQLITE3_TEXT);
			$statement->bindValue(':faculty', $entry->faculty, SQLITE3_TEXT);
			$statement->bindValue(':project', $entry->project, SQLITE3_TEXT);

			if(!SQLite3::exec(self::$db, $statement->execute(), $error_message)) {
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
			
			$statement = self::$db->prepare("DELETE FROM '" . $sqlite_table . "' 
				WHERE email = :email");

			$statement->bindValue(':email', $entry->email, SQLITE3_TEXT);

			if(!SQLite3::exec(self::$db, $statement->execute(), $error_message)) {
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
			
			$statement = "SELECT * FROM '" . $sqlite_table . "';";
			
			$query = SQLite3::query(self::$db, $statement);
			$return = SQLite3::fetch_all($query, SQLITE_ASSOC);

			self::close_db();
			
			return $return;			
	}
}

?>

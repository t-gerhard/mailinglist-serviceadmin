<?php
include_once("config.php");
include_once("data.php");

class sql {

	private static $db;
	
	private static function open_db() {
		$this->db = sqlite_open ($sqlite_database, 0666, $error_message);
		if($error_message != "") {
			return $error_message;
		}

		return "";
	}

	private static function close_db() {
		sqlite_close($this->db);
	}

	public static function add($entry) {
		if(get_class($entry) == "entry") {
			$this->open_db();
			
			$statement = $this->db->prepare("INSERT INTO '" . $sqlite_table . "' (email,fullname,title,status,faculty,project) 
											VALUES (:email,:fullname,:title,:status,:faculty,:project);");

			$statement->bindValue(':email', $entry->email, SQLITE3_TEXT);
			$statement->bindValue(':fullname', $entry->fullname, SQLITE3_TEXT);
			$statement->bindValue(':title', $entry->title, SQLITE3_TEXT);
			$statement->bindValue(':status', $entry->status, SQLITE3_TEXT);
			$statement->bindValue(':faculty', $entry->faculty, SQLITE3_TEXT);
			$statement->bindValue(':project', $entry->project, SQLITE3_TEXT);

			if(!sqlite_exec($this->db, $statement->execute(), $error_message)) {
				return $error_message;				
			}

			$this->close_db();	

		} else {
			return "SQL: Got the wrong attribute class";
		}

		return "";

	}
	
	public static function remove($email) {
		if($email != "") {
			$this->open_db();
			
			$statement = $this->db->prepare("DELETE FROM '" . $sqlite_table . "' 
				WHERE email = :email");

			$statement->bindValue(':email', $entry->email, SQLITE3_TEXT);

			if(!sqlite_exec($this->db, $statement->execute(), $error_message)) {
				return $error_message;				
			}

			$this->close_db();	

		} else {
			return "SQL: Got no E-Mail Address to remove";
		}


		return "";
	}

	public static function list_entry() {
			$this->open_db();
			
			$statement = "SELECT * FROM '" . $sqlite_table . "';";
			
			$query = sqlite_query($this->db, $statement);
			$return = sqlite_fetch_all($query, SQLITE_ASSOC);

			$this->close_db();
			
			return $return;			
	}
}

?>

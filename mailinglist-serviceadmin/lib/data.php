<?php

class entry {
	public $email;
	public $fullname;
	public $title;
	public $status;
	public $faculty;
	public $project;

	function __construct($email,$fullname,$title,$status,$faculty,$project) {
		$this->$email = $email;
		$this->$fullname = $fullname;
		$this->$title = $title;
		$this->$status = $status;
		$this->$faculty = $faculty;
		$this->$project = $project;
	}
}

?>


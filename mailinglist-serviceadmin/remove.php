<?php
include("lib/library.php");

function removeAddress() {
	library::remove($_POST['email']);

	Header("Location: " . $_SERVER['HTTP_REFERER']);
	exit(); 
}

if(isset($_POST['email'])) {
	removeAddress();
} else {
	echo "Error: No email address found";
}
?>





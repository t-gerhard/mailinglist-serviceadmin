<?php
include_once("lib/library.php");

function handleForm() {
	if(isset($_POST['email']) && isset($_POST['fullname']) && isset($_POST['title']) && isset($_POST['status']) && isset($_POST['faculty']) && isset($_POST['project'])) {
		
		$entry = new entry($_POST['email'],$_POST['fullname'],$_POST['title'],$_POST['status'],$_POST['faculty'],$_POST['project']);
		library::add($entry);

		Header("Location: " . $redirect_target);
		exit(); 
	} else {
		echo "Error: Some information is missing";
	}
}

if(isset($_POST['email'])) {
	handleForm();
} #else {
#	Header("Location: " . $_SERVER['HTTP_REFERER']);
#	exit(); 
#}


?>
<html>
	<head>
		<title>
		Registration
		</title>
	</head>
	<body>
		<form action="register.php" method="post">
			<table>
				<tr>
					<td>Title</td>
					<td>
						<select name="title">
							<option value=" ">-</option>
							<option value="Doctor">Doctor</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Full Name</td>
					<td><input type="text/css" name="fullname" /></td>
				</tr>
				<tr>
					<td>E-Mail</td>
					<td><input type="text/css" name="email" /></td>
				</tr>
				<tr>
					<td>Status</td>
					<td>
						<select name="status">
							<option value="Working">Working</option>
							<option value="Doctor">Drinking</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Faculty</td>
					<td>
						<select name="faculty">
							<option value="Informatik">Informatik</option>
							<option value="Doctor">Eletrotechnik</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Project</td>
					<td>
						<input type="text" name="project" />
					</td>
						
				</tr>
				<tr>
					<td colspan="2"><button type="submit">Submit</button> <button type="Cancel">Cancel</button></td>
			</table>
		</form>
	</body>
</html>	


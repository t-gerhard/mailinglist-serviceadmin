<html>
	<head>
		<title>
		Manage List
		</title>
	</head>
	<body>
			<table>
				<thead>
					<th>Email address</th>
					<th>Full Name</th>
					<th>Title</th>
					<th>Status</th>
					<th>Faculty</th>
					<th>Project</th>
					<th />
				</thead>
				<tbody>

<?php
include_once("lib/data.php");
include_once("lib/config.php");
include_once("lib/library.php");

$list = library::list_entries();

foreach ($list as $entry) {
	print "<tr>";
	print "<td>".$entry->email."</td>";
	print "<td>".$entry->fullname."</td>";
	print "<td>".$entry->title."</td>";
	print "<td>".$entry->status."</td>";
	print "<td>".$entry->faculty."</td>";
	print "<td>".$entry->project."</td>";
	
	print "<td>";
	print "<form action=\"remove.php\" method=\"post\">";
	print "<input type=\"hidden\" name=\"email\" value=\"".$entry->email."\" />";
	print "<button type=\"submit\">remove</button>";
	print "</form>";
	print "</td>";

	print "</tr>";
}

?>
				</tbody>
			</table>
	</body>
</html>	


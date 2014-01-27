<?php
class config {
	#some thing something same thing

	public static $redirect_target = "http://ilikecheese.com";

	# SQL settings

	public static $sqlite_database = "/var/sqlite/database";

	# select the table.
	# shema:
	#
	# CREATE TABLE tablename (
	#	email VARCHAR(100) PRIMARY KEY NOT NULL,
	#	fullname VARCHAR(100) NOT NULL,
	#	title VARCHAR(50),
	#	status VARCHAR(50),
	#	faculty VARCHAR(100),
	#	project VARCHAR(100)
	# );

	public static $sqlite_table = "";







	# RPC settings
	public static $rpc_host = "";
	public static $rpc_port = "";
	public static $rpc_username = "";
	public static $rpc_password = "";

}
?>


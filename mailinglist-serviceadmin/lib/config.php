<?php
class config {
	#redirect after successful register:

	public static $redirect_target = "http://ilikecheese.com";






	# SQL settings

	public static $sqlite_database = "/var/www/mailinglist";

	# select the table of the database.
	# required shema:
	#
	# CREATE TABLE ? (
	#	email VARCHAR(100) PRIMARY KEY NOT NULL,
	#	fullname VARCHAR(100) NOT NULL,
	#	title VARCHAR(50),
	#	status VARCHAR(50),
	#	faculty VARCHAR(100),
	#	project VARCHAR(100)
	# );

	public static $sqlite_table = "mailing";

	# Whether to send out emails for mailing list (un)subscription, "1" or "0"
	public static $quiet = "0";

	# RPC settings
	public static $rpc_url = "";
	public static $rpc_username = "";
	public static $rpc_password = "";
  public static $rpc_mailinglist = "";
}
?>
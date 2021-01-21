<?php

$host = "host"; /* Host name */
$user = "user"; /* User */
$password = "password"; /* Password */
$dbname = "db"; /* Database name */

date_default_timezone_set("Europe/Berlin");

$mysqli = new mysqli($host, $user, $password, $dbname);
if ($mysqli->connect_error) {
	exit("Error connecting to database");
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli->set_charset("utf8mb4");

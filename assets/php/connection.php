<?php

$serverName = "localhost";
$username_db = "root";
$password_db = "";
$name_db = "nwssufood_db";

$conn = mysqli_connect($serverName, $username_db, $password_db, $name_db);

if(!$conn)
{
  die("connection failed: " . mysqli_connect_error());
}

// Set the default time zone to New York
date_default_timezone_set('Asia/Manila');

?>
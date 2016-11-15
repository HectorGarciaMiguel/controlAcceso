<?php
$MyUsername = "dbo634603103";  // mysql username
$MyPassword = "antonio1949";  // mysql password
$MyHostname = "db634603103.db.1and1.com";      // Your Host
$Database = "db634603103";    // Name of your database
$dbh = mysqli_connect($MyHostname , $MyUsername, $MyPassword, $Database);
if (!$dbh) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
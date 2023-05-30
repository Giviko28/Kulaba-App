<?php 

$serverName = "localhost";
$user = "root";
// Make sure to check your password and update it here
$password = "";
$db = "webproject";

$conn = new mysqli($serverName, $user, $password,$db, 3307);

if ($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

?>

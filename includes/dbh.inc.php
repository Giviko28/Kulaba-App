<?php 

$serverName = "localhost";
$user = "root";
$password = "Molekula28";
$db = "webproject";

$conn = new mysqli($serverName, $user, $password,$db, 3307);

if ($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

?>

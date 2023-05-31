<?php 
/* Add your own personal servername, username, password.
Make sure to completely remove the 3307 in the end (provided that your default port is 3306).
Do not forget to import .sql file.
*/
$serverName = "localhost";
$user = "root";
$password = "Molekula28";
$db = "webproject";

$conn = new mysqli($serverName, $user, $password,$db, 3307);

if ($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

?>

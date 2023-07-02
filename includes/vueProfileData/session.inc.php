<?php
session_start();
require "../dbh.inc.php";
if (!isset($_SESSION["userid"])) {
    exit();
}
$id = $_SESSION["userid"];

//////////////to update changes of userData/////////////
$stmt = $conn->prepare("SELECT * FROM users WHERE usersId = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    $_SESSION["username"] = $row["usersName"];
    $_SESSION["usermail"] = $row["usersEmail"];
    $_SESSION["userUid"]  = $row["usersUid"];
}


$response = [
    "username" => $_SESSION["username"],
    "usermail" => $_SESSION["usermail"],
    "userUid" => $_SESSION["userUid"],
];

echo json_encode($response);
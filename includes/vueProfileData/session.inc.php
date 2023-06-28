<?php
session_start();
if (!isset($_SESSION["userid"])) {
    exit();
}

$response = [
    "username" => $_SESSION["username"],
    "usermail" => $_SESSION["usermail"],
    "userUid" => $_SESSION["userUid"],
];

echo json_encode($response);
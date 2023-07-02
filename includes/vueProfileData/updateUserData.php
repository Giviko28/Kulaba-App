<?php
session_start();
require "../dbh.inc.php";
require "../../repositories/UserRepository.php";
$userRepository = new userRepository($conn);

$jsonData = file_get_contents('php://input');
$requestData = json_decode($jsonData, true);

function sanitize($value) {
    $value = htmlspecialchars($value);
    $value = stripslashes($value);
    $value = trim($value);
    return $value;
}


$name = sanitize($requestData["name"]);
$email = sanitize($requestData["email"]);
$username = sanitize($requestData["username"]);
$id = $_SESSION["userid"];

if (empty($name) || empty($username)) {
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit();
}


echo $userRepository->updateUserData($name, $email, $username, $id);





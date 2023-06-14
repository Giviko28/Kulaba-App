<?php
session_start();
require_once "dbh.inc.php";
require_once "functions.inc.php";
require_once "../models/user.php";
require_once "../repositories/UserRepository.php";
require_once "../controllers/userController.php";
if (isset($_SESSION["userid"])) {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST["submit"])){
    $userRepository = new UserRepository($conn);
    $userController = new UserController($userRepository);
    echo $userController->LoginUser();
    header("Location: ../landingPage.php");
    exit();
}
/*
if (isset($_POST["submit"])) {

    $username = $_POST["name"];
    $pwd = $_POST["pwd"];

    require "dbh.inc.php";
    require "functions.inc.php";

    if (emptyInputLogin($username, $pwd) !== false) {
        header("Location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn,  $username, $pwd);
} else {
    header("Location: ../login.php");
    exit();
}
*/

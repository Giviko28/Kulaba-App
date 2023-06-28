<?php
require_once "dbh.inc.php";
require_once "functions.inc.php";
require_once "../models/user.php";
require_once "../repositories/UserRepository.php";
require_once "../controllers/userController.php";
if(isset($_POST["submit"])){
    $limiter = new RateLimiter($_SERVER["REMOTE_ADDR"],120, $conn);
    if($limiter->hasExceededRate(3)){
        header("Location: ../signup.php");
        exit();
    }
    $userRepository = new UserRepository($conn);
    $userController = new UserController($userRepository);
    if($userController->CreateUser()){
        header("Location: ../login.php");
    } else {
        header("Location: ../signup.php");
    }
    exit();
} else {
    header("Location: ../login.php");
    exit();
}


/*
if (isset($_POST["submit"])){

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    $name = clean_input($_POST["name"]);
    $email = clean_input($_POST["email"]);
    $username = clean_input($_POST["uid"]);
    $pwd = clean_input($_POST["pwd"]);
    $pwdRepeat = clean_input($_POST["pwdrepeat"]);


    if (emptyInputSignup($name , $email, $username, $pwd, $pwdRepeat) !== false) {
        header("Location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username) !== false) {
        header("Location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false ) {
        header("Location: ../signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeat) !== false) {
        header("Location: ../signup.php?error=passworddsontmatch");
        exit();
    }
    if (uidExists($conn, $username, $email) !== false) {
        header("Location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd);
} else {
    header("Location: ../signup.php");
    exit;
}

*/
<?php
if (isset($_SESSION["userid"])) {
    header("Location: ../index.php");
    exit();
}
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

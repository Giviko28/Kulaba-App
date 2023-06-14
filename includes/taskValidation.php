<?php 
session_start();
require "dbh.inc.php";
require "functions.inc.php";

if (isset($_POST["submit"])) {
    $name = clean_input($_POST["name"]);
    $prize = $_POST["prize"];
    $img = file_get_contents($_FILES["img"]["tmp_name"]);
    $userid = $_SESSION["userid"];
    if(empty($name)){
        header("Location: ../uploadTaskPage.php?error=emptyName");
        exit();
    }
    try {
    $sql = "INSERT INTO surveys(survey_name, userid, coins, image)
    VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siis", $name, $userid, $prize, $img);
    $stmt->execute();
    } catch(Exception $e) {
        die("Error".$e->getMessage());
    }
    header("Location: ../uploadTaskPage.php?error=success");
    exit();
} else {
    header("Location: ../uploadTaskPage.php?error=WrongPath");
    exit();
}






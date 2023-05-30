<?php 
    session_start();
    require ("includes/dbh.inc.php");
    include ("includes/functions.inc.php");
    date_default_timezone_set("Asia/Tbilisi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cssfolder/style.css">
</head>
<body>
    <nav>
        <div class ="wrapper">
            <h1><a href="index.php">KULABA</a></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION["userid"]))
                echo '<li><a href="tasks.php">Tasks</a></li>';
                ?>
                <li><a href="info.php">Info</a></li>
                <?php
                    if (isset($_SESSION["userUid"])) {
                      echo  "<li><a href='profile.php'>Profile</a></li>";
                      if(checkCardPrivilige($conn, $_SESSION["userid"])){
                        echo "<li><a href='uploadPage.php'>Upload Card</a></li>";
                      }
                      if(checkTaskPrivilige($conn, $_SESSION["userid"])){
                        echo "<li><a href='uploadTaskPage.php'>Upload Task</a></li>";
                      }
                      echo  "<li><a href='includes/logout.inc.php'>Log Out</a></li>";
                    } else {
                        echo "<li><a href='signup.php'>Sign Up</a></li>";
                        echo "<li><a href='login.php'>Log In</a></li>";
                    }
                ?>
            </ul>
        </div>
    </nav>
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
    <?php
    $cart ="
    <form id ='cart' action='checkoutPage.php' class = 'cart'>
        <img src='images/cart.jpg' alt''>
        <p class = 'cartCount'></p>
    </form>
    ";
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])){
        echo $cart;
    } else {echo str_replace("class = 'cart'", "class = 'hidden'", $cart);}
    ?>
    <nav>
        <div class ="wrapper">
            <h1><a href="landingPage.php">KULABA</a></h1>
            <ul id ="menu">
                <li><a href="landingPage.php">Home</a></li>
                <?php if (isset($_SESSION["userid"]))
                echo '<li id="nextPage"><a href="tasks.php">Tasks</a></li>';
                ?>
                <li><a href="info.php">Info</a></li>
                <?php
                    if (isset($_SESSION["userid"])) {
                      echo  "<li id='nextPage'><a href='profile.php'>Profile</a></li>";
                      if(checkCardPrivilige($conn, $_SESSION["userid"])){
                        echo "<li id='nextPage'><a href='uploadPage.php'>Upload Card</a></li>";
                      }
                      if(checkTaskPrivilige($conn, $_SESSION["userid"])){
                        echo "<li id='nextPage'><a href='uploadTaskPage.php'>Upload Task</a></li>";
                      }
                      echo  "<li id='nextPage'><a href='includes/logout.inc.php'>Log Out</a></li>";
                    } else {
                        echo "<li id='nextPage'><a href='signup.php'>Sign Up</a></li>";
                        echo "<li id='nextPage'><a href='login.php'>Log In</a></li>";
                    }
                ?>
            </ul>
            <a class ="menuBtn" id = "menuButton"><img src="images/mnu.jpg"></a>

        </div>
        </nav>
        <script>
            const menuButton = document.getElementById('menuButton');
            const menu = document.getElementById('menu');
            const nextPage = document.getElementById("nextPage");
            const checkOut = document.querySelector("#cart");
            const resizeHandler = () => {
                if (window.innerWidth > 576) {
                    menu.style.display = 'flex';
                } else {
                    menu.style.display = 'none';
                }
            };

            const loadHandler = () => {
                if (window.innerWidth > 576) {
                    menu.style.display = 'flex';
                } else {
                    menu.style.display = 'none';
                }
            };
            
            function handleClick() {
            if (menu.style.display === 'none' || window.innerWidth>576) {
                menu.style.display = 'flex';
            } else {
                menu.style.display = 'none';
            }
            }
            function handleClickForBtn() {
            if (menu.style.display === 'none' || window.innerWidth>576) {
                menu.style.display = 'flex';
            } else {
                menu.style.display = 'none';
            }

            }
            checkOut.addEventListener('click', function(){
                let form = this.closest("form");
                if(form) {
                    form.submit();
                }
            });
            window.addEventListener('resize', resizeHandler);
            window.addEventListener('load', loadHandler);
            nextPage.addEventListener('click', handleClick);
            menuButton.addEventListener('click', handleClickForBtn);
        </script>
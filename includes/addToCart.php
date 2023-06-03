<?php
session_start();
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    if(empty($_SESSION["cart"])){
        $cart = array($id);
        $_SESSION["cart"] = $cart;
    } else {
        array_push($_SESSION["cart"], $id);
    }
    
    header("Location: ../productPage.php?cardId=$id");
    exit();
} else {
   
}
<?php
session_start();
if (isset($_POST["id"]) && isset($_SESSION["cart"])) {
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
    header("Location: ../productPage.php?cardId={$_POST['id']}");
    exit();
}
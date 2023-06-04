<?php
require "dbh.inc.php";
require "functions.inc.php";
session_start();
if (isset($_POST["id"]) && isset($_SESSION["cart"])) {
    $cardId = $_POST["id"];
    addToCartById($conn, $cardId);
    $_SESSION["cart"] = checkCart($conn, $_SESSION["userid"]);
    header("Location: ../productPage.php?cardId=$cardId");
    exit();
} else {
    header("Location: ../productPage.php?cardId={$_POST['id']}");
    exit();
}
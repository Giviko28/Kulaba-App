<?php
require "dbh.inc.php";
require "functions.inc.php";
session_start();
if (isset($_GET["id"]) && isset($_SESSION["cart"])) {
    $cardId = $_GET["id"];
    $card = getCardById($conn, $cardId);
    if($card === NULL){
        exit();
    }
    addToCartById($conn, $cardId);
    $_SESSION["cart"] = checkCart($conn, $_SESSION["userid"]);
    echo "დაემატა კალათაში";
} else {
    echo "გაიარე ავტორიზაცია";
}
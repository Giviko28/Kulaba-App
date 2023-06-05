<?php
session_start();
require "../dbh.inc.php";
require "../functions.inc.php";
$realPrice = $salesPrice = $coinPrice = $totalPrice = 0;
if (isset($_SESSION["cart"])) {
$_SESSION["cart"] = checkCart($conn, $_SESSION["userid"]);
foreach ($_SESSION["cart"] as $cardid){
    $card = getCardById($conn, $cardid);
    $realPrice += $card["real_price"];
    $salesPrice += $card["sales_price"];
    $coinPrice += $card["price"];
}
$totalPrice = $realPrice - $salesPrice;
$prices = array(
    "realPrice" => $realPrice,
    "salesPrice" => $salesPrice,
    "totalPrice" => $totalPrice,
    "coinPrice" => $coinPrice
);
echo json_encode($prices);
} else {
    echo "გაიარე ავტორიზაცია";
}
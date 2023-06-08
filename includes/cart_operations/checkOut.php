<?php
session_start();
require_once "../dbh.inc.php";
require_once "../functions.inc.php";

function getUser($conn) {
    $sql = "SELECT * FROM users WHERE usersid = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("i", $_SESSION["userid"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row;
        }
    } else{
        die("Error");
    }
}

function checkCartTotal($conn) {
    $total = 0;
    $userid = $_SESSION["userid"];
    $sql = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){ 
        $stmt->bind_param("i",$userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $card = getCardById($conn, $row["card_id"]);
                $total += $card["price"];
            }
        }
        return $total;
        $stmt->close();
    } else {
        die("Statement error");
    }
}
function updateBalance($conn, $amount){
    $sql = "UPDATE users 
    SET coins = ?
    WHERE usersid = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("ii", $amount, $_SESSION["userid"]);
        $stmt->execute();
        $_SESSION["balance"] = $amount;
    } else {
        die("Stmt error");
    }
    $stmt->close();
}

function makeInvoice($conn, $total){
    $sql = "INSERT INTO invoices (user_id, total) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("ii", $_SESSION["userid"], $total);
        $stmt->execute();
        return $stmt->insert_id;
        $stmt->close();
    } else {
        die("Stmt error");
    }
}

function attachToInvoice($conn, $invoice_id, $card_id, $card_price) {
    $sql = "INSERT INTO invoice_items (card_id, invoice_id, price) VALUES(?,?,?)";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $stmt->bind_param("iii", $card_id, $invoice_id, $card_price);
        $stmt->execute();
        $stmt->close();
    } else {
        die("stmt error");
    }
}

function clearCart($conn){
    $sql = "DELETE  FROM cart where user_id = ?";
    $stmt = $conn->prepare($sql);
    if($stmt){
        $_SESSION["cart"] = array();
        $stmt->bind_param("i", $_SESSION["userid"]);
        $stmt->execute();
        $stmt->close();
    } else {
        die("stmt error");
    }
}

if(isset($_SESSION["cart"])) {
    if(empty($_SESSION["cart"])){
        echo "თქვენი კალათა ცარიელია";
        exit();
    }

    $user = getUser($conn);
    $balance = $user["coins"];
    $cartTotal = checkCartTotal($conn);

    if($balance >= $cartTotal){
    $invoice_id = makeInvoice($conn, $cartTotal);
    updateBalance($conn, $balance - $cartTotal);
    $cart = checkCart($conn, $_SESSION["userid"]); // კალათაში ყველაფერი card_id ით არი შენახული

    foreach($cart as $card_id){
        $card = getCardById($conn, $card_id);
        attachToInvoice($conn, $invoice_id, $card["id"], $card["price"]);
    }
    clearCart($conn);

    echo "ტრანზაქცია დასრულებულია";
    } else {
        echo "არასაკმარისი ბალანსი";
    }
} else {
    echo "Error";
}
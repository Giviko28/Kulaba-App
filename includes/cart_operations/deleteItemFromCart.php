<?php
require "../dbh.inc.php";
session_start();

function deleteCard($conn, $id) {
    $sql = "DELETE FROM cart WHERE card_id = ?";
    try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    } catch (Exception $e) {
        die ('Error'. $e->getMessage());
    }
    return true;
}

if (isset($_GET["id"])){
    if(deleteCard($conn, $_GET["id"]) === true){
        echo "Item removed from cart";
    }
} else {
   echo "Error deleting something that doesn't exist";
}
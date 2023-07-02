<?php

include "dbh.inc.php";


if (isset($_POST["submit"])) {

    $id = $_POST["id"];

    $sql = "DELETE FROM cards WHERE id = ?";
    $sqlImages = "DELETE FROM card_images WHERE card_id = ?";
    try {
        $stmt = $conn->prepare($sqlImages);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } catch (Exception $e) {
        die ('Error'. $e->getMessage());
    }
    try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    } catch (Exception $e) {
        die ('Error'. $e->getMessage());
    }
    header("Location: ../uploadPage.php");
    exit();
} else {
    header("Location: ../uploadPage.php");
    exit();
}
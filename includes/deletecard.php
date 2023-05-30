<?php

include "dbh.inc.php";


if (isset($_POST["submit"])) {

    $id = $_POST["id"];

    $sql = "DELETE FROM cards WHERE id = ?";
    try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    } catch (Exception $e) {
        die ('Error'. $e->getMessage());
    }
    header("Location: ../uploadPage.php");
    exit();
}
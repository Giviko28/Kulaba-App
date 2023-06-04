<?php
session_start();
include "functions.inc.php";
include "dbh.inc.php";

if(isset($_POST["submit"]) && $_FILES["img"]["error"] === 0) {

    $name = clean_input($_POST["name"]);
    $desc = clean_input($_POST["desc"]);
    $price = $_POST["price"];
    $realprice = $_POST["realprice"];
    $salesprice = $_POST["salesprice"];
    $usersid = $_SESSION["userid"];
    $imgPath = $_FILES["img"]["tmp_name"];
    $category_id = $_POST["category_id"];
    $img = file_get_contents($imgPath);
    $imageInfo = getimagesize($imgPath);

    if(emptyCardInfo($name, $desc, $price, $category_id) !== false) {
        header("Location: ../uploadPage.php?error=emptyfields");
        exit();
    }
    if((filter_var($realprice,FILTER_VALIDATE_INT) === false) || (filter_var($salesprice, FILTER_VALIDATE_INT) === false) || (filter_var($price, FILTER_VALIDATE_INT) === false) || (filter_var($category_id,FILTER_VALIDATE_INT) === false)) {
        header("Location: ../uploadPage.php?error=invalidNumType");
        exit();
    }
    if(invalidUid($name) !== false) {
        header("Location: ../uploadPage.php?error=invalidName");
        exit();
    }

    if($imageInfo !== false){
        $imageType = $imageInfo[2];
        $imgSizeInKb = $_FILES["img"]["size"] / 1024;
        if($imageType !== IMAGETYPE_JPEG){
            header("Location: ../uploadPage.php?error=notjpeg");
            exit();
        }
        if($imgSizeInKb > 62){
            header("Location: ../uploadPage.php?error=largeImg");
            exit();
        }
    } else {
        header("Location: ../uploadPAge.php?error=invalidImg");
        exit();
    }

    $sql = "INSERT INTO cards (image, restaurantName, shortDesc, price, usersid, category_id, sales_price, real_price)
    VALUES (?, ?, ?, ?, ?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiiii", $img, $name, $desc, $price, $usersid, $category_id, $salesprice, $realprice);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    header("Location: ../uploadPage.php?error=success");
    exit();
} else {
    header("Location: ../uploadPage.php");
    exit();
}
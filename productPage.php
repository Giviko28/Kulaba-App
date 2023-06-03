<?php require "header.php" ?>
<link rel="stylesheet" href="cssfolder/productPage.css">
<?php 

if (isset($_GET["cardId"])) {
    $id = $_GET["cardId"];
    $card = getCardById($conn, $id);
    echo '
    <main>
    <div class ="left">
        <div class = "slideshow">
            <div class ="imgSideBar">
                <img src="images/marabeli.jpg" alt="">
                <img src="images/marabeli.jpg" alt="">
                <img src="images/marabeli.jpg" alt="">
                <img src="images/marabeli.jpg" alt="">
                <img src="images/marabeli.jpg" alt="">
                <img src="images/marabeli.jpg" alt="">
            </div>
            <div class = "mainImg">
                <img src="images/marabeli.jpg" alt="">
            </div>
        </div>
    </div>

    <div class = "right">
        <span>ფასდაკლება მთავრდება 8 საათში</span>
        <div class = "sale">
        <p class = "newPrice">GEL 325₾</p>
        <p class = "oldPrice">GEL 425₾</p>
        <p class="salePercent">(25%)</p>
        </div>
        <p class ="rating">მარაბელი ★★★★★</p>
        <p class="desc">უგემრიელესი კანჭის მენიუ 10 კაცზე</p>
        <form action="includes/addToCart.php" method ="POST">
            <input type= "hidden" name="id" value = "'.$id.'">
            <button type="submit">კალათაში დამატება</button>
        </form>
    </div>
    </main>
    ';
} else {
    header("Location: landingPage.php");
    exit();
}

?>
<input type="hidden" name="id" value = "$id">
<?php require "footer.php" ?>
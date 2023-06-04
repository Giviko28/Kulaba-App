<?php require "header.php" ?>
<link rel="stylesheet" href="cssfolder/productPage.css">
<?php 

if (isset($_GET["cardId"])) {
    $id = $_GET["cardId"];
    $card = getCardById($conn, $id);
    $img = $card["image"];
    $desc = $card["shortDesc"];
    $realPrice = "GEL".$card["real_price"]." ₾";
    $salesPrice = "GEL".$card["sales_price"]." ₾";
    $salesPercent = round((1-($card["sales_price"]/$card["real_price"]))*100, 0)."%";
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
                <img src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Item Image">
            </div>
        </div>
    </div>

    <div class = "right">
        <span>ფასდაკლება მთავრდება 8 საათში</span>
        <div class = "sale">
        <p class = "newPrice">'. $salesPrice .'</p>
        <p class = "oldPrice">'. $realPrice .'</p>
        <p class="salePercent">('.$salesPercent.')</p>
        </div>
        <p class ="rating">მარაბელი ★★★★★</p>
        <p class="desc">'. $desc .'</p>
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
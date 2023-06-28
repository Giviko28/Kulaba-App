<?php require "header.php" ?>
<link rel="stylesheet" href="cssfolder/productPage.css">
<?php 
if (isset($_GET["cardId"])) {
    $id = $_GET["cardId"];
    $card = getCardById($conn, $id);
    if($card === NULL){
        echo '<meta http-equiv="refresh" content="0;url=landingPage.php">';
        exit;
    }
    $img = $card["image"];
    $desc = $card["shortDesc"];
    $name = $card["restaurantName"];
    $realPrice = "GEL".$card["real_price"]." ₾";
    $salesPrice = "GEL".$card["sales_price"]." ₾";
    $salesPercent = round((1-($card["sales_price"]/$card["real_price"]))*100, 0)."%";
    echo '
    <main>
    <div class ="left">
        <div class = "slideshow">
            <div class ="imgSideBar">
            <img src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Item Image">
                <img src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Item Image">
                <img src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Item Image">
                <img src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Item Image">
                <img src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Item Image">
                <img src="data:image/jpeg;base64,' . base64_encode($img) . '" alt="Item Image">
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
        <p class ="rating">'.$name.' ★★★★★</p>
        <p class="desc">'. $desc .'</p>
        <div>
            <button onclick = "addToCart('.$id.')">კალათაში დამატება</button>
            <p id = "msg" class="msg"></p>
        </div>
    </div>
    </main>
    ';
    echo'
    <script>
    function showMessage(message, duration){
        let msg = document.querySelector("#msg");
        msg.innerText = message;
        msg.style.display = "block";
        setTimeout(function() {
            msg.style.display = "none";
        }, duration);
    };
    function addToCart(id){
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
        ';
                if(isset($_SESSION["cart"])) {
                    echo'
                        let cart = document.querySelector("#cart");
                        cart.className = "cart";
                        ';
                }
    echo'
                showMessage(this.responseText, 2500);
            }
        }
        xhttp.open("GET", "includes/addToCart.php?id=" + id, true);
        xhttp.send();
    }
    </script>
        ';
} else {
    header("Location: landingPage.php");
    exit();
}
?>
<?php require "footer.php" ?>
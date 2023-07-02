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
    ///////////////////////////////
    $stmt = $conn->prepare("SELECT * FROM card_images
    WHERE card_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    for ($set = array (); $row = $result->fetch_assoc(); $set[] = $row);
    ////////////////////////////////
    $desc = $card["shortDesc"];
    $name = $card["restaurantName"];
    $realPrice = "GEL".$card["real_price"]." ₾";
    $salesPrice = "GEL".$card["sales_price"]." ₾";
    $salesPercent = round((1-($card["sales_price"]/$card["real_price"]))*100, 0)."%";
    echo '
    <main>
    <div class ="left">
        <div class = "slideshow">
            <div class ="imgSideBar">';
                for($i = 0; $i<count($set);$i++){
                echo '<img  id ="img'. $i .'" onclick="updateImg('.$i.')"  src="images/'. $set[$i]["image"] .'" alt="Item Image">';
                }
            echo '
            </div>
            <div class = "mainImg">
                <img  id = "mainImg" src="images/' . $set[0]["image"] . '" alt="Item Image">
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
    <script src="includes/productPage.js"></script>
        ';
} else {
    header("Location: landingPage.php");
    exit();
}
?>
<?php require "footer.php" ?>
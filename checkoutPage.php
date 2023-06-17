<?php require "header.php"; ?>
<link rel="stylesheet" href="cssfolder/checkoutPage.css">
<?php
echo '
<p class = "message" id = "message"></p>
<main>
    <div class = "mobileHeader">
        <div class = "exit"><a href ="landingPage.php"><img src="images/arrow-back.png" alt=""></a></div>
        <div class = "mobileRight">
            <img src="images/star.png" alt="">
            <img src="images/3dots.png" alt="">
        </div>
    </div>
    <hr>
    <h2 class ="h2">ჩემი კალათა</h2>
    <div id = "checkout" class = "checkout">
        <div id = "cardwrap" class = "cardwrap">
        </div>
    </div>
</main>';
?>
<script>
    function purchase() {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                document.querySelector("#message").innerHTML = this.responseText;
                loadCart();
            }
        }
        xhttp.open("POST", "includes/cart_operations/checkOut.php", true)
        xhttp.send("");
    }
    function loadCart() {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                let response = JSON.parse(this.responseText);
                const cards = response.cards;
                const prices = response.prices;
                document.querySelector("#cardwrap").innerHTML = cards;
                document.querySelector("#checkout").insertAdjacentHTML('beforeend',prices);
            }
        };
        xhttp.open("POST", "includes/cart_operations/loadCart.php", true);
        xhttp.send();
    }
    function updatePrice() {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState === 4 && this.status === 200){
                let response = JSON.parse(xhttp.responseText);
                document.querySelector("#real").innerHTML = response["realPrice"] + "GEL";
                document.querySelector("#sale").innerHTML = response["salesPrice"] + "GEL";
                document.querySelector("#total").innerHTML = "J" + response["coinPrice"];
                document.querySelector("#saved").innerHTML = response["totalPrice"] + "GEL";
            }
        }
        xhttp.open("POST", "includes/cart_operations/updatePrice.php", true);
        xhttp.send();
    }
    function updateCart(id) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
               document.getElementById(id).remove();
               // document.querySelector("#message").innerHTML = this.responseText;
               updatePrice();
            }
        }
        xhttp.open("GET", "includes/cart_operations/deleteItemFromCart.php?id=" + id, true);
        xhttp.send();
    }
    function changeLabel() {
        if(window.innerWidth <=576){
        document.querySelector("#savedLabel").remove();
        let saved = document.querySelector("#saved");
        saved.innerHTML = "-"+saved.innerHTML;
        }
    }
    window.addEventListener("load", loadCart());
    window.addEventListener("load",changeLabel);
    window.addEventListener('resize',changeLabel);


</script>


<?php require "footer.php"; ?>
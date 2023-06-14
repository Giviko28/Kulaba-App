<?php require "header.php"; ?>
<link rel="stylesheet" href="cssfolder/checkoutPage.css">

<?php
echo '
<p class = "message" id = "message"></p>
<main>
    <div id = "checkout" class = "checkout">
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
                document.querySelector("#checkout").innerHTML = this.responseText;
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
               document.getElementById(id).innerHTML = "";
               document.getElementById(id).style.display = "none";
               document.querySelector("#message").innerHTML = this.responseText;
               updatePrice();
            }
        }
        xhttp.open("GET", "includes/cart_operations/deleteItemFromCart.php?id=" + id, true);
        xhttp.send();
    }
    
    window.addEventListener("load", loadCart());


</script>


<?php require "footer.php"; ?>
<?php 
    session_start();
    require ("includes/dbh.inc.php");
    include ("includes/functions.inc.php");
    date_default_timezone_set("Asia/Tbilisi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="cssfolder/style.css">
    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff; /* Set your desired background color */
            opacity: 1; /* Set the desired opacity */
            z-index: 9999; /* Ensure the overlay appears on top */
            display: flex;
            justify-content:center;
            align-items:center;
            transition: opacity 0.5s ease;
        }
        #loading {
            height: 100px;
            width:100px;
        }
        
    </style>
</head>
<body>
    <div id="loading-overlay"><img id="loading" src="images/loading.gif" alt="Loading icon"></div>
    <div class = "results" id="results"></div>
    <?php
    $cart ="
    <form id ='cart' action='checkoutPage.php' class = 'cart'>
        <img src='images/cart.jpg' alt''>
        <p class = 'cartCount'></p>
    </form>
    ";
    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])){
        echo $cart;
    } else {echo str_replace("class = 'cart'", "class = 'hidden'", $cart);}
    ?>
    <nav>
        <div class ="wrapper">
            <h1><a href="landingPage.php">KULABA</a></h1>
            <div  class = "tags">
                <a href="index.php">TOP შეთავაზებები</a>
                <a href="tasks.php">კითხვარები</a>
                <a href="info.php">ინფო</a>
            </div>
            <div class = "searchDiv">
                <img src="images/search-icon.png" alt="">
                <input id = "search" type="text" name = "search" placeholder = "მოძებნე სასურველი შეთავაზება">
            </div>
            <div class = "userbox">
            <?php
                if(isset($_SESSION["userid"])){
                    echo "<a class ='user' href='profile.php'>".$_SESSION["username"]."</a>";
                    echo "<a class ='user bal' href='profile.php'>J".$_SESSION["balance"].".00</a>";
                } else {
                    echo "<a class ='user' href='login.php'>შესვლა</a>";
                    echo "<a class ='user' href='signup.php'>რეგისტრაცია</a>";
                }
            ?>
        </div>
            <a class ="menuBtn" id = "menuButton"><img src="images/mnu.jpg"></a>
            <div id = "menu" class="mobileMenu">
            <hr style = "border-color:white; margin-top:1%;">
                <a id = 'nextPage' href="landingPage.php">მთავარი გვერდი</a>
                <?php
                if(isset($_SESSION["userid"])){
                echo "<a id = 'nextPage' href='profile.php'>პროფილი</a>";
                }
                ?>
                <a href="index.php">შეთავაზებები</a>
                <a href="tasks.php">კითხვარები</a>
                <?php
                if(isset($_SESSION["userid"])){
                echo "<a href='includes/logout.inc.php'>გასვლა</a>";
                } else {
                    echo "<a href='login.php'>შესვლა</a>";
                    echo "<a href='signup.php'>რეგისტრაცია</a>";
                }
                ?>
        </div>

        </div>
        </nav>
        <script>
            const search = document.querySelector("#search");
            const resultsContainer = document.querySelector("#results");
            function fetchCards(description){
                let http = new XMLHttpRequest();
                http.onreadystatechange = function(){
                    if(this.readyState === 4 && this.status === 200){
                        resultsContainer.innerHTML = "";
                        resultsContainer.style.display = "flex";
                        let cards = JSON.parse(this.responseText);
                        if(this.responseText.length === 2){
                            resultsContainer.innerHTML = "შედეგი არ მოიძებნა";
                        }
                        cards.forEach((card)=>{
                            const div = document.createElement("div");
                            div.classList.add("result");
                            const link = document.createElement("a");
                            link.href = "productPage.php?cardId=" + card.id;
                            link.style.textDecoration = "none";
                            link.style.color = "inherit";
                            link.addEventListener("click", function(event) {
                                event.stopPropagation(); // Prevents the click event from bubbling up to the div
                            });

                            const img = document.createElement("img");
                            img.src = "data:image/png;base64," + card.image;
                            link.appendChild(img);

                            const nameParagraph = document.createElement("p");
                            nameParagraph.textContent = card.restaurantName;
                            link.appendChild(nameParagraph);

                            const descDiv = document.createElement("div");
                            descDiv.classList.add("resultPrices");

                            const descParagraph = document.createElement("p");
                            descParagraph.classList.add("resultSalesPrice")
                            descParagraph.textContent = card.sales_price+"₾";
                            descDiv.appendChild(descParagraph);

                            const priceParagraph = document.createElement("p");
                            priceParagraph.classList.add("resultRealPrice")
                            priceParagraph.textContent = card.real_price+"₾";
                            descDiv.appendChild(priceParagraph);
                            
                            link.appendChild(descDiv);

                            div.appendChild(link);
                            resultsContainer.appendChild(div);
                        })
                    }
                }
                http.open("GET", "includes/search.inc.php?desc=" + description, true);
                http.send();
            }
            search.addEventListener("keyup", () => {
                if(search.value.trim() === ""){
                    resultsContainer.innerHTML = "";
                    resultsContainer.style.display = "none";
                    return;
                }
                fetchCards(search.value);
            });
            search.addEventListener("blur", ()=>{
                blurTimeout = setTimeout(() => {
                resultsContainer.innerHTML = "";
                resultsContainer.style.display = "none";
            }, 150);
            });
            search.addEventListener("focus", ()=>{
                if(search.value.trim() != ""){
                fetchCards(search.value);
                }
            });

        </script>
        <script>
            const menuButton = document.getElementById('menuButton');
            const xBtn = document.querySelector(".xBtn");
            let imgElement = menuButton.querySelector("img");
            const menu = document.getElementById('menu');
            const nextPage = document.querySelectorAll("nextPage");
            const checkOut = document.querySelector("#cart");
            checkOut.addEventListener('click', function(){
                let form = this.closest("form");
                if(form) {
                    form.submit();
                }
            });
            
            menuButton.addEventListener("click", ()=>{
                if(menu.style.display === "none"){
                    menu.style.display = "flex";
                    imgElement.src = "images/mnu2.png"
                    menuButton.classList.replace("menuBtn", "xBtn");
                } else {
                    menu.style.display = "none";
                    imgElement.src = "images/mnu.jpg"
                    menuButton.classList.replace("xBtn", "menuBtn");
                }
            });
           window.addEventListener('resize', () =>{
            if(window.innerWidth > 1024){
                menu.style.display = "none";
                imgElement.src = "images/mnu.jpg";
                menuButton.classList.replace("xBtn", "menuBtn");
            }
           })
           window.addEventListener('load', () =>{
                menu.style.display = "none";
                imgElement.src = "images/mnu.jpg";
                menuButton.classList.replace("xBtn", "menuBtn");
           })

        </script>
        <script>
            window.addEventListener('load', function() {
                var overlay = document.getElementById('loading-overlay');
                overlay.style.opacity = 0; // Set opacity to 0 to hide the overlay
                overlay.style.pointerEvents = 'none'; // Allow interaction with the content
                setTimeout(function() {
                    overlay.style.display = 'none'; // Hide the overlay after the transition
                }, 500);
         });
        </script>
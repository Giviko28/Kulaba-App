<?php require "header.php"?>
<link rel="stylesheet" href="cssfolder/landingPage.css">

<main>

    <div class="slideshow">
        <div class="mySlides">
            <img src="images/banner2.jpg" alt="">
        </div>
        <div class="mySlides">
            <img src="images/banner1.jpg" alt="">
        </div>
        <div class="mySlides">
            <img src="" alt="">
        </div>
        <button onclick = "plusSlides(-1)" class="prev"><</button>
        <button onclick = "plusSlides(1)" class="next">></button>
    </div>

    <div class="categories">
        <div class="category">
            <div class = "text">
                <h2 class = "h2Text">სუში</h2>
                <p class = "pText">50% მდე ფასდაკლება ყველა სეტზე</p>
                <a class = "aText" href="">დაზოგე ახლა -></a>
            </div>
            <div class ="categoryImg">
                <img src="images/landing1.jpg" alt="">
            </div>
        </div>
        <div class="category">
            <div class = "text">
                <h2 class = "h2Text">ხინკალი</h2>
                <p class = "pText">იქეიფე შენ გემოზე</p>
                <a class = "aText" href="">დაზოგე ახლა -></a>
            </div>
            <div class = "categoryImg">
                <img src="images/landing2.jpg" alt="">
            </div>
        </div>
        <div class="category">
            <div class="text">
                <h2 class = "h2Text">პიცა</h2>
                <p class = "pText">ხაჭაპურს არ სჯობს, მაგრამ ცდად ღირს</p>
                <a class = "aText" href="">დაზოგე ახლა -></a>
            </div>
            <div class ="categoryImg">
                <img src="images/landing3.png" alt="">
            </div>
        </div>
    </div>

    <div class ="recent">
        <div class="title">
            <h2>ბოლოს დამატებული</h2>
            <a href="index.php">ყველას ნახვა</a>
        </div>
        <div class = "recentCards">
            <?php printCards(10, getRecentCards($conn)); ?>
        </div>
    </div>
</main>

<script src="includes/landingPage.js"></script>
<?php require "footer.php" ?>

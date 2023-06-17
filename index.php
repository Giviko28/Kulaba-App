<?php include "header.php" ?>
<link rel="stylesheet" href="cssfolder/topDeals.css">
<main>
    <section class ="filter">
        <!-- <form action="index.php" method="POST">
            <h1>კატეგორიები</h1>
            <div>
               სუში <input type="checkbox" name="category1" value = 1>
            </div>
            <div>
               პიცა <input type="checkbox" name="category2" value = 2>
            </div>
            <div>
              რესტორანი<input type="checkbox" name="category3" value = 3>
            </div>

            <input type="submit" value ="გაფილტრე">
        </form> -->
        <div class = 'filterTitle'>
        <h1>შეთავაზებები</h1>
        <input class = 'srch' id = 'filterSearch' type="text" placeholder = 'მოძებნე სასურველი შეთავაზება'>
        </div>

        <form action="index.php" method="POST">
        <div class ='filterBtns'>
                <div>
                    <label for="category">კატეგორია</label>
                    <p name = 'category'>რესტორანი</p>
                    <img src="images/expand.png" alt="">
                </div>
                <div>
                    <label for="">სუბ-კატეგორია</label>
                    <p name = 'subcategory'>ყველა</p>
                    <img id = 'subcategory' src="images/expand.png" alt="">
                </div>
                <div id = 'subList' class ='subList'>
                    <div>
                        <p>სუში</p>
                        <input type="checkbox" name="category1" value = 1>
                    </div>
                    <div>
                        <p>პიცა</p>
                        <input type="checkbox" name="category2" value = 2>
                    </div>
                    <div>
                        <p>რესტორანი</p>
                        <input type="checkbox" name="category3" value = 3>
                    </div>
                </div>
                <div>
                    <label for="price">ფასი</label>
                    <p name = 'price'>0₾-999₾</p>
                    <img src="images/expand.png" alt="">
                </div>
                <div>
                    <label for="location">მდებარეობა</label>
                    <p name = 'location'>თბილისი</p>
                </div>
                <button type = 'submit'>ძებნა</button>
        </div>
        </form>
    </section>
    
    <section class="items">
<?php
    $arr = array();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach($_POST as $value) {
            array_push($arr, $value);
        }
    }
    $result = getCards($conn, $arr);

    while ($row = $result->fetch_assoc()) {
        $cardId = $row["id"];
        $img = $row["image"];
        $name = $row["restaurantName"];
        $desc = $row["shortDesc"];
        $price = $row["price"];
        $sales_price = $row["sales_price"];
        $real_price = $row["real_price"];
        echo "
        <form class = 'card' action = 'productPage.php' method = 'GET'>
        <img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Item Image'>
        <p class ='title'>$name</p>
        <p class ='desc'>$desc</p>
        <hr>
            <div class='priceTag'>
                <div class='salesDiv'>
                    <p class='salePrice'>
                        ".$sales_price."₾
                    </p>
                    <p class='realPrice'>
                        ".$real_price."₾
                    </p>
                </div>
                <p class ='cost'>$price ჯიზია</p>
            </div>
            <input type='hidden' value = $cardId name = 'cardId'>
        </form>
        ";
    // Process each row of the result
    // Access column values using $row['column_name']
    }
    ?>
    </section>
  

</main>

<script>
    const filterSearch = document.querySelector("#filterSearch");
    const subcategoryBtn = document.querySelector("#subcategory");
    window.addEventListener('load', () => {
        if(window.innerWidth <= 576){filterSearch.placeholder = "ძებნა";}
    });
    subcategoryBtn.addEventListener('click', () => {
        if(window.innerWidth > 576){return;}
        const subList = document.querySelector("#subList");
        if(subList.style.display == "flex"){
            subList.style.display = 'none';
        } else {subList.style.display = 'flex';}
    });

    let cards = document.getElementsByClassName("card");

// მასივად ვაქცევთ getElementsByClassName-იდან მიღებულ ინფორმაციას
let cardsArray = [...cards];

cardsArray.forEach(function(card) {
  card.addEventListener("click", function(event) {
    event.preventDefault();

    // Find the closest form element to the clicked card
    let form = this.closest('form');
    
    if (form) {
      form.submit(); // Submit the form
    }
  });
});
</script>
<?php include "footer.php" ?>

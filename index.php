<?php include "header.php" ?>
<link rel="stylesheet" href="cssfolder/cardsmain.css">
<main>
    <section class ="filter">
        <form action="index.php" method="POST">
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
        $img = $row["image"];
        $name = $row["restaurantName"];
        $desc = $row["shortDesc"];
        $price = $row["price"];
        /*
        echo "
        <div class='card'>
        <img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Item Image'>
        <h2>$name</h2>
        <p>$desc</p>
        <span>$price ჯიზია</span>
        </div>
        "
        */
        echo "
        <div class = 'card'>
        <img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Item Image'>
        <p class ='title'>$name</p>
        <p class ='desc'>$desc</p>
        <hr>
            <div class='priceTag'>
                <div class='salesDiv'>
                    <p class='salePrice'>
                        325₾
                    </p>
                    <p class='realPrice'>
                        425₾
                    </p>
                </div>
                <p class ='cost'>$price ჯიზია</p>
            </div>
        </div>
        ";
    // Process each row of the result
    // Access column values using $row['column_name']
    }
    ?>
    </section>
  

</main>

<?php include "footer.php" ?>

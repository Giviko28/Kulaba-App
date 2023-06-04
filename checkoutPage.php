<?php require "header.php"; ?>
<link rel="stylesheet" href="cssfolder/checkoutPage.css">

<?php
$totalRealPrice = $totalSalesPrice = $totalCoinPrice = 0;
echo '
<main>
    <div class = "checkout">
        <div class = "items">';
                if(isset($_SESSION["cart"])){
                    $arr = $_SESSION["cart"];
                    for($i = 0; $i<count($arr);$i++){
                        $card = getCardById($conn, $arr[$i]);
                        $img = $card["image"];
                        $shortDesc = $card["shortDesc"];
                        $coinPrice = $card["price"];
                        $realPrice = $card["real_price"];
                        $salesPrice = $card["sales_price"];
                        $totalCoinPrice += $coinPrice;
                        $totalSalesPrice += $salesPrice;
                        $totalRealPrice += $realPrice;
                        echo "
                    <form class ='container'>
                        <img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Item Image'>
                    <div class = 'titles' >
                        <p>$shortDesc</p>
                        <p>$coinPrice ჯიზია</p>
                        <p class = 'amount'>1</p>
                        <p>$realPrice GEL</p>
                    </div>
                    </form>";
                    }
                }
        echo '
        </div>
        <div class = "price">
        ';
        $savedTotal = $totalRealPrice - $totalSalesPrice;
        echo "
                <div>
                    <p>რეალური ფასი</p>
                    <p>$totalRealPrice GEL</p>
                </div>
                <div>
                    <p>ფასდაკლებული ფასი</p>
                    <p>$totalSalesPrice GEL</p>
                </div>
                <div>
                    <p>ქოინური ფასი</p>
                    <p>$totalCoinPrice</p>
                </div>
                <div>
                    <p>დაზოგილი თანხა</p>
                    <p>$savedTotal GEL</p>
                </div>
                <form action=''>
                    <button type='submit'>შეძენა</button>
                </form>
        </div>
        ";
        ?>
    </div>
</main>
<?php


?>


<?php require "footer.php"; ?>
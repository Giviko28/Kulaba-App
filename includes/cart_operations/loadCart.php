<?php
session_start();
require "../dbh.inc.php";
require "../functions.inc.php";
$totalRealPrice = $totalSalesPrice = $totalCoinPrice = 0;
if(isset($_SESSION["cart"])){
    $_SESSION["cart"] = checkCart($conn, $_SESSION["userid"]);
    $arr = $_SESSION["cart"];
    echo"<div class ='items'>";
    if(empty($arr)){
        echo"თქვენი კალათა ცარიელია";
    }
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
        <div id = $arr[$i] class ='container'>
            <img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Item Image'>
        <div class = 'titles' >
            <p>$shortDesc</p>
            <p>$coinPrice ჯიზია</p>
            <p class = 'amount'>1</p>
            <p>$realPrice GEL</p>
        </div>
        <button onclick='updateCart($arr[$i])'><img src='images/trashCan.png' alt=''></button>
        </div>";
        }
        echo"</div>";
        $savedTotal = $totalRealPrice-$totalSalesPrice;
        // ფასის მხარე 
        echo "
        <div class = 'price'>
            <div>
                <p>რეალური ფასი</p>
                <p id = 'real'>$totalRealPrice GEL</p>
            </div>
            <div>
                <p>ფასდაკლებული ფასი</p>
                <p id = 'sale'>$totalSalesPrice GEL</p>
            </div>
            <div>
                <p>ქოინური ფასი</p>
                <p id = 'total'>$totalCoinPrice</p>
            </div>
            <div>
                <p>დაზოგილი თანხა</p>
                <p id = 'saved'>$savedTotal GEL</p>
            </div>
            <form action=''>
                <button type='submit'>შეძენა</button>
            </form>
        </div>
        ";
}
 else {
    echo"დარეგისტრირდი და დაიწყე დაზოგვა";
}



?>
<?php
session_start();
require "../dbh.inc.php";
require "../functions.inc.php";
$totalRealPrice = $totalSalesPrice = $totalCoinPrice = 0;
if (isset($_SESSION["cart"])) {
    $_SESSION["cart"] = checkCart($conn, $_SESSION["userid"]);
    $arr = $_SESSION["cart"];
    $cards = "";
    $prices = "";

    if (empty($arr)) {
        $cards = "თქვენი კალათა ცარიელია";
    } else {
        for ($i = 0; $i < count($arr); $i++) {
            $card = getCardById($conn, $arr[$i]);
            $img = $card["image"];
            $shortDesc = $card["shortDesc"];
            $coinPrice = $card["price"];
            $realPrice = $card["real_price"];
            $salesPrice = $card["sales_price"];
            $totalCoinPrice += $coinPrice;
            $totalSalesPrice += $salesPrice;
            $totalRealPrice += $realPrice;
            $cards .= "
            <div id='$arr[$i]' class='container $arr[$i]'>
                <img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Item Image'>
                <div class='titles'>
                    <p class = 'shortDesc'>$shortDesc</p>
                    <p class ='coinPrice'>J$coinPrice</p>
                    <p class='amount'>1</p>
                    <p class = 'realPrice'>$realPrice GEL</p>
                </div>
                <button onclick='updateCart($arr[$i])'><img src='images/trashCan.png' alt=''></button>
            </div>";
        }

        $savedTotal = $totalRealPrice - $totalSalesPrice;

        $prices = "
        <div class='price'>
            <div id = 'realDiv'>
                <p id = 'realTitle'>რეალური ფასი</p>
                <p id='real'>$totalRealPrice GEL</p>
            </div>
            <div id = 'saleDiv'>
                <p id = 'saleTitle'>ფასდაკლებული ფასი</p>
                <p id='sale'>$totalSalesPrice GEL</p>
            </div>
            <div id = 'totalDiv'>
                <p id='totalLabel'>ქოინური ფასი</p>
                <p id='total'>J$totalCoinPrice</p>
            </div>
            <div id = 'savedDiv'>
                <p id ='savedLabel'>დაზოგილი თანხა</p>
                <p id='saved'>$savedTotal GEL</p>
            </div>
            <div class='btn'>
                <button onclick='purchase()' type='submit'>დაზოგვა</button>
            </div>
        </div>
        ";
    }

    $response['cards'] = $cards;
    $response['prices'] = $prices;

    echo json_encode($response);
}
 else {
    echo"დარეგისტრირდი და დაიწყე დაზოგვა";
}



?>
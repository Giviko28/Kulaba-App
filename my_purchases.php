<?php 
    include "header.php";
    require_once "models/user.php";
    require_once "repositories/UserRepository.php";
    if(!isset($_SESSION["userid"])){
        header("Location: signup.php");
        exit();
    }
    $userRepository = new UserRepository($conn);
    $savings = $userRepository->getSavings($_SESSION["userid"]);
    $_SESSION["saved"] = $savings[0] - $savings[1];
    $_SESSION["real_price"] = $savings[0];
    $_SESSION["sales_price"] = $savings[1];
?>
<link rel="stylesheet" href="cssfolder/my_purchases.css">
<main>
    <div class = "root">
        <a href="profile.php">< ანგარიში</a>
        <h1>ჩემი შეთავაზებები</h1>

        <div class = "total">
            <div class = "left">
                <div>
                    <h2>₾<?php echo $_SESSION["real_price"] ?></h2>
                    <p>ჯამური თანხა</p>
                </div>
                <h1>-</h1>
                <div>
                    <h2>₾<?php echo $_SESSION["sales_price"] ?></h2>
                    <p>ფასდაკლებული თანხა</p>
                </div>
                <h1 class ="equals">=</h1>
            </div>

            <div class = "right">
                    <h2>₾<?php echo $_SESSION["saved"]?>*</h2>
                    <p>დაზოგილი თანხა</p>
            </div>
        </div>
    
        <p class = "disclaimer">*თანხა გამოითვლება რეალური ფასების ჯამისა და ფასდაკლებული ფასების სხვაობით, რის შემდგომაც მიიღება დაზოგილი თანხა</p>

        <h2 class ="historyTitle">ისტორია</h2>
        <div class = "history">
            <?php
            $userRepository = new UserRepository($conn);
            $invoices = $userRepository->getInvoices($_SESSION["userid"]);
            foreach($invoices as $invoice){
                $dateTime = new DateTime($invoice["invoice_date"]);
                $date = $dateTime->format("Y-m-d");
                echo"
                <div>
                    <p class = 'id'>ID: ".$invoice["invoice_id"]."</p>
                    <p class = 'date'>შეძენის თარიღი: ".$date."</p>
                    <p class = 'price'>ფასი: J".$invoice["total"]."</p>
                </div>
                ";
            }
            ?>
        </div>

    </div>
</main>

<?php include "footer.php"; ?>
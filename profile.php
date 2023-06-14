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
?>
<link rel="stylesheet" href="cssfolder/profile.css">
<main>
    <div class = "content">
        <p>ანგარიში</p>
        <div class = "description">
            <div class = "detailsRoot">
                <img src="images/defaultPic.png" alt="">
                <div class =  "details">
                    <h2>გამარჯობა, <?php echo $_SESSION["username"]?></h2>
                    <p><?php echo $_SESSION["usermail"] ?></p>
                </div>
            </div>

            <div class ="detailsRoot2">
                <div class = "savings">
                    <h3>დანაზოგი</h3>
                    <p>₾<?php echo $_SESSION["saved"] ?></p>
                </div>
                <div class = "balance">
                    <h3>ბალანსი</h3>
                    <p>J<?php echo $_SESSION["balance"] ?></p>
                </div>
            </div>
        </div>

        <div class = "settingsNav">
            <div>
                <div><img src="images/Screenshot_43.png" alt=""></div>
                <a href="my_purchases.php">ჩემი შეთავაზებები ></a>
                <p>შეიძინე შეთავაზებები და იხილე აქ</p>
            </div>
            <div>
                <div><img src="images/Screenshot_44.png" alt=""></div>
                <a href="includes/logout.inc.php">პროფილი ></a>
                <p>ჩაასწორე ან იხილე შენი პროფილი</p>
            </div>
            <div>
                <div><img src="images/Screenshot_45.png" alt=""></div>
                <a href="">გადახდის მეთოდი ></a>
                <p>დაამატე ან გააუქმე ბარათი</p>
            </div>
            <?php 
            if(checkCardPrivilige($conn, $_SESSION["userid"])){
            echo '
            <div>
                <div><img src="images/Screenshot_45.png" alt=""></div>
                <a href="">შეთავაზების დამატება></a>
                <p>დაეხმარე ხალხს დაზოგოს ფული</p>
            </div>
            ';
            }
            ?>
        </div>

    </div>
</main>

<?php include "footer.php" ?>
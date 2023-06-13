<?php 
include "header.php"; 
require_once "models/user.php";
require_once "repositories/UserRepository.php";
if(!isset($_SESSION["userid"])){
    header("Location: signup.php");
    exit();
}
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
                    <p>₾0.00</p>
                </div>

                <div class = "balance">
                    <h3>ბალანსი</h3>
                    <p>J0.00</p>
                </div>
            </div>
        </div>

        <div class = "settingsNav">
            <div>
                <div><img src="images/Screenshot_43.png" alt=""></div>
                <a href="">ჩემი შეთავაზებები ></a>
                <p>შეიძინე შეთავაზებები და იხილე აქ</p>
            </div>
            <div>
                <div><img src="images/Screenshot_44.png" alt=""></div>
                <a href="">პროფილი ></a>
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
                <a href="">გადახდის მეთოდი ></a>
                <p>დაამატე ან გააუქმე ბარათი</p>
            </div>
            ';
            }
            ?>
        </div>

    </div>
</main>

<script>
</script>

<?php include "footer.php" ?>
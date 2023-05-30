<?php include "header.php";

/* es komentari moshale tu misha mogbezrda, komentari daemata testirebis miznit
if (isset($_SESSION["userid"])) {
    header("Location: index.php");
    exit();
}
*/

?>

    <section class="sign-up">
        <h2>Login</h2>
        <form action="includes/login.inc.php" method="post">
            <input type="text" name="name" placeholder = "Username/Email:">
            <input type="password" name="pwd" placeholder = "Password:">
            <button type="submit" name = "submit">Log In</button>
        </form>
        <?php 
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Fill in all field </p>";
        }
        else if ($_GET["error"] == "wrongLogin") {
            echo "<p>Invalid login credentials</p>";
        }
        else if ($_GET["error"] == "success") {
            $username = $_SESSION["userUid"];
            echo "<p style='color: red;' class = 'successMSG'>გამარჯობა აგენტო $username</p>";
            echo '<img class ="misha" src="https://cdn.gweb.ge/buffer/1001663/pictures/fullsize/a4f9cd23eb3c5264c37dca61222d678e.jpg" alt="">';
        }
    }
    ?>
    </section>


<?php include "footer.php" ?>
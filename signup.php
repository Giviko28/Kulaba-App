<?php include "header.php" ?>
<img src="images/signup.png" alt="" class="backGround">
<link rel="stylesheet" href="cssfolder/signup.css">
    <main>
            <h2>შემოგვიერთდით</h2>
            <p>გაქვს უკვე ანგარიში? <a href="login.php">Log in</a></p>
        <div class = "box">
            <form id = "signupForm" action="includes/signup.inc.php" onsubmit = "return validateForm()" method="post">
                <input onchange = "validateName()" type="text" name="name" placeholder = "სახელი:">
                <input onchange = "validateEmail()" type="text" name="email" placeholder = "მეილი:">
                <input onchange = "validateUsername()" type="text" name="uid" placeholder = "პირობითი სახელი:">
                <input onchange = "validatePwd()" type="password" name="pwd" placeholder = "პაროლი:">
                <input onchange = "validatePwdRepeat()" type="password" name="pwdrepeat" placeholder = "გაიმეორეთ პაროლი:">
                <div class= "messages">
                    <span id = "name">სახელი არ უნდა იყოს ცარიელი</span>
                    <span id = "email">მეილის ფორმატი უნდა იყოს სწორი</span>
                    <span id = "username">პირობითი სახელი არ უნდა იყოს ცარიელი</span>
                    <span id = "pwd">პაროლი უნდა შეიცავდეს 8 სიმბოლოს, 1 დიდი, 1 პატარა და 1 ციფრი</span>
                    <span id = "pwdRepeat">პაროლები უნდა ემთხვეოდეს</span>
                </div>
                <button id = "submit" class ="inActiveBtn" type="submit" name = "submit">რეგისტრაცია</button>
            </form>
            <?php 
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Fill in all field </p>";
                    }
                    else if ($_GET["error"] == "invaliduid") {
                        echo "<p>Invalid username</p>";
                    }
                    else if ($_GET["error"] == "invalidemail") {
                        echo "<p>Enter a valid email or username</p>";
                    }
                    else if ($_GET["error"] == "passworddsontmatch") {
                        echo "<p>The passwords don't match</p>";
                    }
                    else if ($_GET["error"] == "usernametaken") {
                        echo "<p>Email or Username already taken </p>";
                    }
                    else if ($_GET["error"] == "statementfailed") {
                        echo "<p>Something went wrong... Try again later</p>";
                    }
                    else if ($_GET["error"] == "none") {
                        echo "<p style = \"color: green;\">Succesfully signed up!</p>";
                    }
                }
            ?>
        </div>

    </main>
    <script src="includes/signupAndLogin.js"></script>
<?php include "footer.php" ?>
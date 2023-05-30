<?php include "header.php" ?>
    <section class="sign-up">
        <h2>Sign Up</h2>
        <form action="includes/signup.inc.php" method="post">
            <input type="text" name="name" placeholder = "Name:">
            <input type="text" name="email" placeholder = "Email:">
            <input type="text" name="uid" placeholder = "Username:">
            <input type="password" name="pwd" placeholder = "Password:">
            <input type="password" name="pwdrepeat" placeholder = "Repeat your password:">
            <button type="submit" name = "submit">Sign Up</button>
        </form>
    <?php 
    if (isset($_GET["error"])) {
        echo "<style>
            p {
                color: red;
            }
        </style>";
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
    </section>

<?php include "footer.php" ?>
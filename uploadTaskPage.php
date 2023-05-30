<?php include "header.php"; ?>

<link rel="stylesheet" href="cssfolder/uploadTaskPage.css">
<main>

    <div class = "left">
        <?php 
            if(!($_SERVER["REQUEST_METHOD"] == "POST")){
                echo '
                    <form action="uploadTaskPage.php" method="POST">
                        <input type="submit" value="კითხვარის შექმნა">
                    </form>
                ';
            } else {
                echo '
                <form action="includes/taskValidation.php" method="post">
                    <input type="text" name="name" placeholder = "კითხვარის სახელი">
                    <input type="number" min="0" max="1000" name="prize" placeholder = "პრიზი ქოინის სახით">
                    <input type="submit" name="submit" value="შედგენა">
                </form>
                ';
            }
        ?>
    </div>

    <div class="right">

    </div>

</main>

<?php include "footer.php" ?>
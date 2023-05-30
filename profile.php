<?php include "header.php"; ?>
<link rel="stylesheet" href="cssfolder/profile.css">

<main>
    <section class="description">
        <div class="descbox">
            <div>
            <h2>ზედმეტსახელი:</h2>
            <p><?php echo $_SESSION["userUid"] ?> </p>
            </div>
            <div>
            <h2>სახელი:</h2>
            <p><?php echo $_SESSION["username"] ?></p>
            </div>
            <div>
            <h2>ქოინები:</h2>
            <p><?php echo $_SESSION["balance"] ?></p>
            </div>
        </div>
    </section>

    <section class="myVouchers">
        <h1>აქტიური ვაუჩერები</h1>
        <div class="activeVouchers">

        </div>
    </section>

</main>


<?php include "footer.php" ?>
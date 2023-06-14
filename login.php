<?php include "header.php";?>
<link rel="stylesheet" href="cssfolder/login.css">
<img src="images/signup.png" alt="" class="backGround">
<main>
    <h2>გაიარე ავტორიზაცია</h2>
    <p>არ გაქვს ანგარიში? <a href="signup.php">Sign Up</a></p>
    <section class="login">
        <form action="includes/login.inc.php" method="post">
            <label for="name">მეილი/იუზერი</label>
            <input id = "name" type="text" name="name" placeholder = "მეილი/იუზერი:">
            <label for="pwd">პაროლი</label>
            <input id = "pwd" type="password" name="pwd" placeholder = "პაროლი:">
            <button id ="btn" class = "inActiveBtn" type="submit" name = "submit">ავტორიზაცია</button>
            <a href="">დაგავიწყდა პაროლი?</a>
            <div class="or-container">
                <div class="line"></div>
                <div class="or-text">OR</div>
                <div class="line"></div>
            </div>
            <div class = "connectParent">
                <div class = "connect"><img src="images/facebook.png" alt="">შესვლა Facebook-ით</div>
                <div class = "connect"><img src="images/Google.png" alt="">შესვლა Google-ით</div>
                <div class = "connect"><img src="images/apple.png" alt="">შესვლა Apple-ით</div>
            </div>
        </form>
    </section>
</main>

<script>
    const name = document.querySelector("#name");
    const pwd = document.querySelector("#pwd");
    const btn = document.querySelector("#btn");
    function isEmpty() {
        if(name.value.trim().length <=0 || pwd.value.trim().length <=0){
            btn.className = "inActiveBtn";
            return;
        }
        btn.className = "activeBtn";
    }
    name.addEventListener("keyup", isEmpty);
    pwd.addEventListener("keyup", isEmpty);
</script>
<?php include "footer.php" ?>
<?php include "header.php" ?>
<link rel="stylesheet" href="cssfolder/uploadPage.css">
<section class="items">
        <form class="voucher" action="uploadPage.php" method="post">
        <button class="uploadBtn" type="submit">ვაუჩერის დამატება</button>
        </form>
        <div class ="myitems">
            <?php 
                if(!isset($_SESSION["userid"])){
                    header("Location: landingPage.php");
                    exit(); 
                }
                if($_SERVER["REQUEST_METHOD"] != "POST"){
                $id = $_SESSION["userid"];
                $stmt = $conn->prepare("SELECT * FROM cards WHERE usersid = (?)");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                while($row = $result->fetch_assoc()) {
                    $img = $row["image"];
                    $name = $row["restaurantName"];
                    $desc = $row["shortDesc"];
                    $price = $row["price"];
                    $cardId = $row["id"];
                    echo "
                <form action='includes/deletecard.php' method='POST'>
                    <div class = 'card'>
                    <img src='data:image/jpeg;base64," . base64_encode($img) . "' alt='Item Image'>
                    <p class ='title'>$name</p>
                    <p class ='desc'>$desc</p>
                    <hr>
                        <div class='priceTag'>
                            <div class='salesDiv'>
                                <p class='salePrice'>
                                    325₾
                                </p>
                                <p class='realPrice'>
                                    425₾
                                </p>
                            </div>
                            <p class ='cost'>$price ჯიზია</p>
                        </div>
                    <input type='hidden' name = 'id' value = $cardId>
                    <button name = 'submit' class ='deleteBtn'>X</button>
                    </div>
                </form>";;
                }
            } else {
                echo '
                <form class="upload" method="POST" action="includes/uploadCard.php" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="რესტორანის სახელი:">
                    <input type="text" name="desc" placeholder="მოკლე აღწერა">
                    <input type="number" min="0" max="10000" name="price" placeholder="ფასი">
                    <input type="number" min="0" max="1000" name="realprice" placeholder="რეალური ფასი">
                    <input type="number" min="0" max="1000" name="salesprice" placeholder="ფასდაკლებული ფასი">
                    <select name="category_id">
                        <option value="" disabled selected>აირჩიე კატეგორია</option>
                        <option value=1>სუში</option>
                        <option value=2>პიცა</option>
                        <option value=3>რესტორანი</option>
                    </select>
                    <input type="file" name="img" >
        
                    <button class ="submit" name = "submit" type="submit">ატვირთვა</button>
                </form>
                ';
            }
            ?>
        </div>
    </section>



<?php include "footer.php" ?>
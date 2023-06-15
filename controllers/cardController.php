<?php

class CardController {
    private $cardRepository;

    public function __construct(CardRepository $cardRepository) {
        $this->cardRepository = $cardRepository;
    }
    
    public function createCard() {

        $image = file_get_contents($_FILES["img"]["tmp_name"]);
        $restaurantName = $_POST["name"];
        $shortDesc = $_POST["desc"];
        $price = $_POST["price"];
        $usersid = $_SESSION["userid"];
        $category_id = $_POST["category_id"];
        $real_price = $_POST["realprice"];
        $sales_price = $_POST["salesprice"];

        // Error handlers უსაფრთხოება.
        $errors = [];
        $imageInfo = getimagesize($_FILES["img"]["tmp_name"]);
        if($imageInfo !== false){
            $imageType = $imageInfo[2];
            $imgSizeInKb = $_FILES["img"]["size"] / 1024;
            if($imgSizeInKb > 256){
                $errors[] = "Img size must be below 256";
            }
            if($imageType !== IMAGETYPE_JPEG){
                $errors[] = "Img must be a JPEG";
            }
        }
        if(!empty($errors)){
            echo json_encode($errors);
            return;
        }

        $card = new Card($image, $restaurantName, $shortDesc, $price, $usersid, $category_id, $real_price, $sales_price);
    
        $this->cardRepository->save($card);
    }
}
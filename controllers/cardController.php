<?php

class CardController {
    private $cardRepository;

    public function __construct(CardRepository $cardRepository) {
        $this->cardRepository = $cardRepository;
    }
    
    public function createCard() {
        $restaurantName = $_POST["name"];
        $shortDesc = $_POST["desc"];
        $price = $_POST["price"];
        $usersid = $_SESSION["userid"];
        $category_id = $_POST["category_id"];
        $real_price = $_POST["realprice"];
        $sales_price = $_POST["salesprice"];
        
        $images = 0;
        $imageNames = [];
        $allowedExtentions = ["image/jpeg", "image/jpg", "image/png"];
        $uploadDir = "C:/Users/Giviko/procedural/images/";

        if (!is_array($_FILES["image"]["name"]) || !isset($_POST["submit"])) {
            return;
        }

        foreach($_FILES["image"]["name"] as $key => $name) {
            $errors = [];
            if (!is_uploaded_file($_FILES["image"]["tmp_name"][$key])) {
                continue;
            }
            $mimeType = mime_content_type($_FILES["image"]["tmp_name"][$key]);

            if(!in_array($mimeType, $allowedExtentions, true)){
                $errors[] = "Invalid extension";          
            }
            if ($_FILES["image"]["error"][$key] == 4) {
                $errors[] = "Error within image";
            }
            if ($_FILES["image"]["size"][$key]/1024 > 512) {
                $errors[] = "Image too big";
            }
            if (!$this->cardRepository->isImageNameSafe($name)) {
                $errors[] = "Wrong image name";
            }

            if (!empty($errors)) {
                echo json_encode($errors);
                exit();
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"][$key], $uploadDir . $name)) {
                $images++;
                $imageNames[] = $name;
                // $this->cardRepository->uploadImagePath($lastId, $name);
            } else {
                exit();
            }
        }
        if ($images > 0 && $images < 6) {
            $card = new Card($restaurantName, $shortDesc, $price, $usersid, $category_id, $real_price, $sales_price);
            $lastId = $this->cardRepository->save($card);
            foreach($imageNames as $imageName) {
                $this->cardRepository->uploadImagePath($lastId, $imageName);
            }
        } else {
            exit();
        }

        
        /*
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
        */
    }
}
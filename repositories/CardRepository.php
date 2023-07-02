<?php

class CardRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getById($id) {
        $sql = "SELECT * FROM cards WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bind_param("i", $id);
            $result = $stmt->execute()->get_result()->fetch_assoc();
            if(!$result){
                return null;
            }

            $card = new Card($result["id"], $result["image"], $result["restaurantName"], $result["shortDesc"], $result["price"], $result["usersid"], $result["categoryid"], $result["real_price"], $result["sales_price"]);
            return $card;
        } else {
            die("Statement error");
            exit();
        }
    }
    public function getByDescription($description){
        include "../includes/functions.inc.php";
        try {
            $stmt = $this->db->prepare("SELECT * FROM cards WHERE shortDesc LIKE CONCAT('%', ?, '%')");
            $stmt->bind_param("s", $description);
            $stmt->execute();
            $result = $stmt->get_result();
            $cards = [];
            while($row = $result->fetch_assoc()){
                $imgName = getCardFirstImage($row["id"]);
                $card = array(
                    "id" => $row["id"],
                    "image" => $imgName,
                    "restaurantName" => $row["restaurantName"],
                    "shortDesc" => $row["shortDesc"],
                    "price" => $row["price"],
                    "usersid" => $row["usersid"],
                    "category_id" => $row["category_id"],
                    "real_price" => $row["real_price"],
                    "sales_price" =>$row["sales_price"]
                );
                $cards[] = $card;
            }
            return $cards;
        } catch (Exception $e) {
            die("An error occurred: " . $e->getMessage());
        }
    }
    public function getAll() {
        $sql = "SELECT * FROM cards";
        $stmt = $this->db->prepare($sql);
        if($stmt){
           $stmt->execute();
           $result = $stmt->get_result();
           $cards = [];
           while($row = $result->fetch_assoc()){
                $card = new Card(
                    $row["id"],
                    $row["image"],
                    $row["restaurantName"],
                    $row["shortDesc"],
                    $row["price"],
                    $row["usersid"],
                    $row["categoryid"],
                    $row["real_price"],
                    $row["sales_price"]
                );
                $cards[] = $card;
           }
           return $cards;
        } else {
            die("Statement error");
            exit();
        }
    }
    public function isImageNameSafe($filename): bool {
        if (!preg_match("`^[-0-9A-Z_\.]+$`i", $filename)) {
            return false;
        }
        if (strlen($filename) > 250) {
            return false;
        }
        return true;
    }
    public function uploadImagePath($card_id, $path) {
        $stmt = $this->db->prepare("INSERT INTO card_images(card_id, image)
        VALUES (?, ?)");
        $stmt->bind_param("is", $card_id, $path);
        $stmt->execute();
    }
    public function save(Card $card) {
        $sql = "INSERT INTO cards (restaurantName, shortDesc, price, usersid, category_id, real_price, sales_price)
        VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bind_param("ssiiiii",$card->getRestaurantName(), $card->getShortDesc(), $card->getPrice(), $card->getUsersId(), $card->getCategoryId(), $card->getRealPrice(), $card->getSalesPrice());
            $stmt->execute();
        } else {
            die("Statement error");
            exit();
        }
        return $this->db->insert_id;
    }
    public function delete(Card $card) {
        $sql = "SELECT * FROM cards WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bind_param("i", $card->getId());
            $stmt->execute();
        } else {
            die("Stmt error");
            exit();
        }
    }
}
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
    public function getAll() {
        $sql = "SELECT * FROM cards";
        $stmt = $this->db->prepare($sql);
        if($stmt){
           $result = $stmt->execute()->get_result();
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
    public function save(Card $card) {
        $sql = "INSERT INTO cards (image, restaurantName, shortDesc, price, usersid, category_id, real_price, sales_price)
        VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bind_param("sssiiiii",$card->getImage(), $card->getRestaurantName(), $card->getShortDesc(), $card->getPrice(), $card->getUsersId(), $card->getCategoryId(), $card->getRealPrice(), $card->getSalesPrice());
            $stmt->execute();
        } else {
            die("Statement error");
            exit();
        }
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
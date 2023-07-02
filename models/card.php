<?php

class Card {
 // მონაცემთა ბაზაში ქარდების სრული აღწერა / All columns of table "cards" in Database
    private $id;
    private $image;
    private $restaurantName;
    private $shortDesc;
    private $price;
    private $usersid;
    private $categoryid;
    private $real_price;
    private $sales_price;

    public function __construct($restaurantName, $shortDesc, $price, $usersid, $categoryid,$real_price, $sales_price) {
        $this->restaurantName = $restaurantName;
        $this->shortDesc = $shortDesc;
        $this->price = $price;
        $this->usersid = $usersid;
        $this->categoryid = $categoryid;
        $this->real_price = $real_price;
        $this->sales_price = $sales_price;
    }
    public function getId() {
        return $this->id;
    }
    public function getImage() {
        return $this->image;
    }
    public function getRestaurantName() {
        return $this->restaurantName;
    }
    public function getShortDesc() {
        return $this->shortDesc;
    }
    public function getPrice() {
        return $this->price;
    }
    public function getUsersId() {
        return $this->usersid;
    }
    public function getCategoryId() {
        return $this->categoryid;
    }
    public function getRealPrice() {
        return $this->real_price;
    }
    public function getSalesPrice() {
        return $this->sales_price;
    }
}
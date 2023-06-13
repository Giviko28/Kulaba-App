<?php

class User {
    private $id;
    private $usersname;
    private $usersEmail;
    private $usersUid;
    private $usersPwd;
    private $coins;

    public function __construct($usersname, $usersEmail, $usersUid, $usersPwd, $coins){
        $this->usersname = $usersname;
        $this->usersEmail = $usersEmail;
        $this->usersUid = $usersUid;
        $this->usersPwd = $usersPwd;
        $this->coins = $coins;
    }

    public function getId(){
        return $this->id;
    }
    public function getUsersName(){
        return $this->usersname;
    }
    public function getUsersEmail(){
        return $this->usersEmail;
    }
    public function getUsersUid(){
        return $this->usersUid;
    }
    public function getUsersPwd(){
        return $this->usersPwd;
    }
    public function getCoins(){
        return $this->coins;
    }
}
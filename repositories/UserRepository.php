<?php

class UserRepository {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getUser($id) {
        $sql = "SELECT * FROM users WHERE usersid = ?";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $user = new User($row["usersid"], $row["usersName"], $row["usersEmail"], $row["usersUid"], $row["usersPwd"], $row["coins"]);
            return $user;
        } else {
            die("statement error");
            exit();
        }
    }
}
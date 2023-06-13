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
    public function getInvoices($id) {
        $stmt = $this->db->prepare("SELECT * FROM invoices WHERE user_id = ?");
        if($stmt){
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            $invoices = [];
            while($row = $res->fetch_assoc()){
                $invoice = array(
                    "invoice_id" => $row["invoice_id"],
                    "invoice_date" => $row["invoice_date"],
                    "total" => $row["total"]
                );
                $invoices[] = $invoice;
            }
            return $invoices;
        } else {
            die("Statement error");
            exit();
        }
    }
    public function getSavings($id){
        $arr = $this->getInvoices($id);
        $sales_price = $real_price = 0;
        foreach($arr as $invoice){
            $invoice_id = $invoice["invoice_id"];
            $stmt = $this->db->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
            $stmt->bind_param("i", $invoice_id);
            $stmt->execute();
            $itemsResult = $stmt->get_result();
            while($row = $itemsResult->fetch_assoc()){
                $cardStmt = $this->db->prepare("SELECT * FROM cards WHERE id = ?");
                $cardStmt->bind_param("i", $row["card_id"]);
                $cardStmt->execute();
                
                $prices = $cardStmt->get_result()->fetch_assoc();
                $sales_price += $prices["sales_price"];
                $real_price += $prices["real_price"];
            }
        }
        $answers = array($real_price, $sales_price);
        return $answers;
    }
}
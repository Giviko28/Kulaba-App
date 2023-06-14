<?php
require_once "dbh.inc.php";
require_once "../repositories/CardRepository.php";
require_once "../models/card.php";

$cardRepository = new CardRepository($conn);
$desc = $_GET["desc"];
$cards = $cardRepository->getByDescription($desc);
echo json_encode($cards);
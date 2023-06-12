<?php
session_start();
require_once "dbh.inc.php";
require_once "../controllers/cardController.php";
require_once "../models/card.php";
require_once "../repositories/CardRepository.php";

$cardRepository = new CardRepository($conn);
$cardController = new CardController($cardRepository);

$cardController->createCard();

header("Location: ../uploadPage.php");
<?php
require 'controller.php';

$wallets = [];
$transactions = [];

do {
    afficherMenu();
    $choix = trim(readline("Votre choix : "));
    traiterChoix($choix, $wallets, $transactions);
} while ($choix !== "0");
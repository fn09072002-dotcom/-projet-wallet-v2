<?php
require 'controller.php';

$wallets      = [];
$transactions = [];

do {
    \Wallet\Controller\afficherMenu();
    $choix = readline("Votre choix : ");
    \Wallet\Controller\traiterChoix($choix, $wallets, $transactions);
} while ($choix !== "0");
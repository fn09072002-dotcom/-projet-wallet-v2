<?php
namespace Wallet\Controller;

require 'services.php';

function afficherMenu(): void {
    echo "\n** Menu Distributeur **\n";
    echo "1 - Créer Wallet\n";
    echo "2 - Faire Dépôt\n";
    echo "3 - Faire Retrait\n";
    echo "4 - Lister les Transactions\n";
    echo "0 - Quitter\n";
}

function traiterChoix(string $choix, array &$wallets, array &$transactions): void {
    switch ($choix) {
        case "1":
            $client    = readline("Nom du client : ");
            $telephone = readline("Numéro de téléphone : ");
            $code      = readline("Code secret : ");
            $solde     = (float) readline("Solde initial : ");
            echo \Wallet\Services\creerWallet($wallets, $client, $telephone, $code, $solde) . "\n";
            break;

        case "2":
            $telephone = readline("Numéro de téléphone : ");
            $montant   = (float) readline("Montant : ");
            echo \Wallet\Services\faireDepot($wallets, $transactions, $telephone, $montant) . "\n";
            break;

        case "3":
            $telephone = readline("Numéro de téléphone : ");
            $montant   = (float) readline("Montant : ");
            echo \Wallet\Services\faireRetrait($wallets, $transactions, $telephone, $montant) . "\n";
            break;

        case "4":
            $rep = readline("Tous (T) ou numéro spécifique (N) ? ");
            if (strtoupper($rep) === "N") {
                $telephone = readline("Numéro de téléphone : ");
                echo \Wallet\Services\listerTransactions($transactions, $telephone) . "\n";
            } else {
                echo \Wallet\Services\listerTransactions($transactions) . "\n";
            }
            break;

        case "0":
            echo "Au revoir !\n";
            break;

        default:
            echo "Choix invalide, veuillez réessayer\n";
    }
}
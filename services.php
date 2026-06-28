<?php
namespace Wallet\Services;

require 'validator.php';
require 'repository.php';

function creerWallet(array &$wallets, string $client, string $telephone, string $code, float $solde): string {
    if (empty($client) || empty($telephone) || empty($code)) {
        return "Tous les champs sont obligatoires !";
    }
    if (!\Wallet\Validator\validerLongueur($telephone, 9)) {
        return "Le téléphone doit avoir exactement 9 chiffres !";
    }
    if (!\Wallet\Validator\validerPrefixe($telephone)) {
        return "Format téléphone invalide !";
    }
    if (!\Wallet\Validator\validerLongueur($code, 4)) {
        return "Le code doit avoir exactement 4 caractères !";
    }
    if (!\Wallet\Validator\validerSolde($solde)) {
        return "Le solde initial doit être positif ou nul !";
    }

    $unicite = \Wallet\Validator\validerUnicite($wallets, $telephone, $code);
    if ($unicite === 2) return "Ce numéro existe déjà !";
    if ($unicite === 3) return "Ce code existe déjà !";

    \Wallet\Repository\ajouterWallet($wallets, [$client, $telephone, $code, $solde]);
    return "Wallet créé avec succès pour $client !";
}

function faireDepot(array &$wallets, array &$transactions, string $telephone, float $montant): string {
    $index = \Wallet\Repository\trouverWallet($wallets, $telephone);
    if ($index === -1) {
        return "Aucun wallet trouvé pour ce numéro !";
    }
    if ($montant <= 0) {
        return "Le montant doit être strictement positif !";
    }
    \Wallet\Repository\mettreAJourSolde($wallets, $index, $montant);
    \Wallet\Repository\ajouterTransaction($transactions, ["Dépôt", $telephone, $montant, 0]);
    return "Dépôt de {$montant} CFA effectué !\nNouveau solde : {$wallets[$index][3]} CFA";
}

function calculerFrais(float $montant): float {
    if ($montant <= 10000) {
        return 200;
    } elseif ($montant <= 100000) {
        return 500;
    } else {
        return min($montant * 0.01, 5000);
    }
}

function faireRetrait(array &$wallets, array &$transactions, string $telephone, float $montant): string {
    $index = \Wallet\Repository\trouverWallet($wallets, $telephone);
    if ($index === -1) {
        return "Aucun wallet trouvé pour ce numéro !";
    }
    if ($montant <= 0) {
        return "Le montant doit être strictement positif !";
    }
    $frais       = calculerFrais($montant);
    $totalDebite = $montant + $frais;
    if ($wallets[$index][3] < $totalDebite) {
        return "Solde insuffisant !\nSolde actuel : {$wallets[$index][3]} CFA\nTotal à débiter : {$totalDebite} CFA";
    }
    \Wallet\Repository\mettreAJourSolde($wallets, $index, -$totalDebite);
    \Wallet\Repository\ajouterTransaction($transactions, ["Retrait", $telephone, $montant, $frais]);
    return "Retrait de {$montant} CFA effectué !\nFrais : {$frais} CFA\nTotal débité : {$totalDebite} CFA\nNouveau solde : {$wallets[$index][3]} CFA";
}

function listerTransactions(array $transactions, ?string $telephone = null): string {
    if (empty($transactions)) {
        return "Aucune transaction enregistrée !";
    }

    if ($telephone !== null) {
        $transactions = array_values(
            array_filter($transactions, fn($t) => $t[1] === $telephone)
        );
    }

    if (empty($transactions)) {
        return "Aucune transaction trouvée pour ce numéro !";
    }

    $lignes = array_map(function($t, $i) {
        return implode("\n", [
            "\n-- Transaction " . ($i + 1) . " --",
            "Type      : {$t[0]}",
            "Téléphone : {$t[1]}",
            "Montant   : {$t[2]} CFA",
            "Frais     : {$t[3]} CFA",
        ]);
    }, $transactions, array_keys($transactions));

    return "\n=== Historique des Transactions ===\n" . implode("\n", $lignes);
}
<?php
namespace Wallet\Repository;

function ajouterWallet(array &$wallets, array $wallet): void {
    $wallets[] = $wallet;
}

function trouverWallet(array &$wallets, string $telephone): int {
    $index = array_search($telephone, array_column($wallets, 1));
    return $index !== false ? $index : -1;
}

function mettreAJourSolde(array &$wallets, int $index, float $montant): void {
    $wallets[$index][3] += $montant;
}

function ajouterTransaction(array &$transactions, array $transaction): void {
    $transactions[] = $transaction;
}
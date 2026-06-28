<?php
namespace Wallet\Validator;

function validerLongueur(string $valeur, int $longueur): bool {
    return strlen($valeur) === $longueur;
}

function validerPrefixe(string $telephone): bool {
    $prefixes = ["77", "78", "76", "70", "75"];
    return in_array(substr($telephone, 0, 2), $prefixes);
}

function validerUnicite(array &$wallets, string $telephone, string $code): int {
    if (array_search($telephone, array_column($wallets, 1)) !== false) return 2;
    if (array_search($code,      array_column($wallets, 2)) !== false) return 3;
    return -1;
}

function validerSolde(float $solde): bool {
    return $solde >= 0;
}

function validerSoldeDisponible(float $solde, float $totalDebite): bool {
    return $solde >= $totalDebite;
}
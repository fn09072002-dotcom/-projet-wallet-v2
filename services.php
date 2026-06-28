<?php
require 'validator.php';
require 'repository.php';

function creerWallet(&$wallets, $client, $telephone, $code, $solde) {
    if (empty($client) || empty($telephone) || empty($code)) {
        return "Tous les champs sont obligatoires !";
    }
    if (!validerLongueur($telephone, 9)) {
        return "Le téléphone doit avoir exactement 9 chiffres !";
    }
    if (!validerPrefixe($telephone)) {
        return "Format téléphone invalide !";
    }
    if (!validerLongueur($code, 4)) {
        return "Le code doit avoir exactement 4 caractères !";
    }
    if (!validerSolde($solde)) {
        return "Le solde initial doit être positif ou nul !";
    }
    $unicite = validerUnicite($wallets, $telephone, $code);
    if ($unicite === 2) return "Ce numéro existe déjà !";
    if ($unicite === 3) return "Ce code existe déjà !";
    ajouterWallet($wallets, [$client, $telephone, $code, $solde]);
    return "Wallet créé avec succès pour $client !";
}
function faireDepot(&$wallets, &$transactions, $telephone, $montant) {
    $index = trouverWallet($wallets, $telephone);
    if ($index === -1) {
        return "Aucun wallet trouvé pour ce numéro !";
    }
    if ($montant <= 0) {
        return "Le montant doit être strictement positif !";
    }
    mettreAJourSolde($wallets, $index, $montant);
    ajouterTransaction($transactions, ["Dépôt", $telephone, $montant, 0]);
    return "Dépôt de {$montant} CFA effectué !\nNouveau solde : {$wallets[$index][3]} CFA";
}
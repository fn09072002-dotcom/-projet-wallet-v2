# Projet E-Wallet PHP Console

## Description
Application de gestion de portefeuille électronique (E-Wallet) en PHP procédural, exécutée en console.  
Développée en deux parties : fondamentaux procéduraux (Partie A) puis professionnalisation avec fonctions natives et namespaces (Partie B).

## Architecture
```
projet-wallet-v2/
├── index.php        → Point d'entrée, boucle principale
├── controller.php   → Saisies et affichage résultats  (Wallet\Controller)
├── services.php     → Logique métier                  (Wallet\Services)
├── repository.php   → Gestion des données             (Wallet\Repository)
└── validator.php    → Validations                     (Wallet\Validator)
```

## Fonctionnalités
- Créer un wallet (numéro unique, code secret unique, solde initial)
- Faire un dépôt
- Faire un retrait (avec frais par paliers)
- Lister les transactions (globales ou par wallet)

## Frais de retrait
| Montant retiré        | Frais                        |
|-----------------------|------------------------------|
| 0 – 10 000 CFA        | 200 CFA (fixe)               |
| 10 001 – 100 000 CFA  | 500 CFA (fixe)               |
| > 100 000 CFA         | 1% du montant, plafonné à 5 000 CFA |

## Installation
```bash
git clone https://github.com/fn09072002-dotcom/-projet-wallet-v2.git
cd projet-wallet-v2
php index.php
```

## Versions
| Version | Description |
|---------|-------------|
| v0.1.0  | Menu interactif |
| v0.2.0  | Création de wallet |
| v0.3.0  | Dépôt |
| v0.4.0  | Retrait avec frais |
| v0.5.0  | Listing des transactions |
| **v1.0.0** | **Livraison Partie A** (procédural, sans fonctions natives, sans namespaces) |
| v1.1.0  | Refacto avec fonctions natives array (`array_filter`, `array_map`, etc.) |
| v1.2.0  | Intégration des namespaces (`Wallet\*`) |
| **v2.0.0** | **Livraison Partie B** (fonctions natives + namespaces) |

## Stratégie Git
- `main` : versions stables taguées uniquement
- `develop-partA` : intégration Partie A
- `develop-partB` : intégration Partie B
- `feature/*` : une branche par fonctionnalité

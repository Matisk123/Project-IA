# Stratégie Git et Règles d'Intégration

Ce document définit la stratégie Git à adopter pour ce projet, afin de structurer la collaboration.

## 1. Branches

- **Branche de référence** : `main`. C'est la branche par défaut qui contient le code en production ou validé.
- **Branches de travail** : Toute évolution doit se faire sur une branche dédiée, créée à partir de `main`.
  - Nouvelles fonctionnalités : `feature/nom-de-la-fonctionnalite`
  - Corrections de bugs : `bugfix/nom-du-bug`
  - Corrections urgentes en production : `hotfix/nom-du-probleme`
  - Technique/Tâches de maintenance : `chore/nom-de-la-tache`

## 2. Règles de modification et de fusion

- **Aucun push direct sur la branche de référence** : Les modifications directes sur `main` sans passer par une procédure de vérification sont strictement interdites.
- **Pull Requests (PR) / Merge Requests (MR)** : Toute intégration vers la branche principale doit passer par l'ouverture d'une Pull Request depuis la branche de travail.
- **Mises à jour obligatoires** : Avant d'ouvrir une PR, la branche de travail doit intégrer (merge ou rebase) les dernières modifications de `main`.

## 3. Règles de revue (Review) avant intégration

- **Vérifications préalables** : Les tests automatisés (si existants) doivent passer avec succès et la qualité du code (linting) doit être respectée avant la demande de revue.
- **Revue croisée (ou auto-revue)** : Une PR nécessite idéalement la lecture et validation d'au moins un autre membre de l'équipe (Review). En cas de travail en solitaire, le développeur s'engage à effectuer une "auto-revue" systématique de ses changements complets (vérification de la propreté du code, de la sécurité et des logs) avant toute fusion de la branche de travail.

Cette stratégie doit être respectée par l'ensemble des collaborateurs ainsi que par les agents de codage (comme Antigravity).

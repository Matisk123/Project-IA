# Dossier de Sécurité Applicative - Project IA

Ce document résume l'analyse de sécurité réalisée dans le cadre de l'US33 pour le projet de gestion d'événements de la Coding Factory.

## 1. Analyse des risques (Top OWASP)

| Risque | Description | Statut | Mesure associée |
| :--- | :--- | :--- | :--- |
| **A01:2021-Broken Access Control** | Un étudiant accède aux fonctions de manager (suppression d'un événement). | 🛡️ Protégé | Utilisation d'une `EventPolicy` centralisée. |
| **A03:2021-Injection** | Injection SQL via les champs de recherche ou formulaires. | 🛡️ Protégé | Utilisation de l'ORM Eloquent (requêtes paramétrées). |
| **A04:2021-Insecure Design** | Un manager tente de s'inscrire à son propre événement. | 🛡️ Protégé | Règle métier bloquante dans le contrôleur. |
| **A05:2021-Security Misconfig** | Affichage des erreurs détaillées en production (`APP_DEBUG=true`). | ⚠️ Risque bas | Géré par la configuration `.env` (non commitée). |

## 2. Mesures de réduction des risques Appliquées

### ✅ Mesure 1 : Contrôle d'Accès Centralisé (Policies)
Plutôt que de multiplier les `if (role === 'manager')`, nous utilisons le système de **Policies** de Laravel.
- **Bénéfice** : Réduit le risque d'oubli d'une vérification sur une nouvelle route.
- **Preuve** : Fichier `app/Policies/EventPolicy.php`.

### ✅ Mesure 2 : Protection contre le Mass Assignment
Toutes les entrées utilisateur sont filtrées via la propriété `$fillable` dans les modèles.
- **Bénéfice** : Empêche un utilisateur malveillant de modifier son propre rôle ou l'ID d'un événement en injectant des champs cachés dans un formulaire.
- **Preuve** : Modèles `User.php` et `Event.php`.

### ✅ Mesure 3 : Limitation de débit (Rate Limiting)
Mise en place d'une limitation des tentatives d'inscription pour éviter le "spam" d'inscriptions/désinscriptions.
- **Bénéfice** : Protège contre les attaques par déni de service ciblées sur les relations de base de données.
- **Preuve** : Application du middleware `throttle` sur la route `events.register.toggle`.

## 3. Limites connues et Futur (Post-MVP)

- **Gestion des Secrets** : Pour le moment, les secrets (Sonar Token, DB Key) sont gérés via les GitHub Secrets, ce qui est standard.
- **Authentification** : Utilisation de Laravel Breeze (standard industriel), mais pas de 2FA implémenté dans cette version.
- **Logs** : Les logs ne sont pas encore centralisés (audit trail limité).

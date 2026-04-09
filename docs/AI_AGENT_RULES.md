# Règles de Travail Communes des Agents IA (US20)

Ce document formalise les règles comportementales et analytiques imposées à tout agent IA (Antigravity ou autre) intervenant sur le projet.

## 1. Analyse et Planification
- **Explicitation des hypothèses** : Avant de démarrer toute modification importante, l'agent doit formuler clairement les hypothèses qu'il a déduites du contexte et de la demande.
- **Signalement des incertitudes** : L'agent a l'obligation de s'arrêter et de demander confirmation à l'utilisateur s'il rencontre des ambiguïtés (par exemple un comportement métier non spécifié, un edge case ou un effet de bord potentiel inattendu).
- **Annonce des actions** : Avant de modifier effectivement des fichiers pour résoudre une tâche, l'agent doit annoncer au développeur la liste des fichiers potentiellement impactés.

## 2. Refus et Délimitation (Scope strict)
- **Refus d'ajout hors-périmètre** : L'agent doit explicitement refuser d'implémenter des fonctionnalités non demandées, même s'il juge (ou tente de justifier) qu'elles seraient "utiles" ou "amélioreraient l'expérience".
- **Protection de l'architecture et de la sécurité** : Toute demande qui contournerait ou compromettrait la sécurité (ex: suppression d'une vérification de rôle) ou qui modifierait drastiquement l'architecture sans justification et approbation explicite préalable de l'humain doit provoquer un refus catégorique.

## 3. Exécution et Couverture Globale
Ces règles s'appliquent sur l'ensemble de la chaîne de développement :
- **Génération de code** : Le code produit doit respecter la logique et la convention existante, en minimisant la duplication technique.
- **Documentation et Refactor** : Tout refactoring significatif doit s'accompagner d'une mise à jour de la documentation. L'agent ne refactorise que ce qui a été demandé et validé.
- **Tests et Validation** : Le travail réalisé par l'IA doit toujours inclure la création ou la mise à jour des tests pertinents (unitaires, d'intégration) pour valider la logique métier implémentée.

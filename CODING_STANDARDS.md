# Charte de Qualité de Code - Project IA

Cette charte définit les règles à suivre par l'équipe de développement pour assurer la pérennité, la lisibilité et la maintenabilité du projet.

## 1. Principes Fondamentaux (DRY, KISS, SOLID)

- **S**éparation des responsabilités : Les contrôleurs ne doivent gérer que le flux de la requête. La logique métier doit être dans les modèles, services ou actions.
- **D**RY (Don't Repeat Yourself) : Toute logique répétée (comme l'autorisation par rôle) doit être factorisée dans un Middleware ou une Policy Laravel.
- **L**isibilité : Le code doit être clair au premier coup d'œil. Préférez des noms de variables descriptifs plutôt que des abréviations cryptiques.

## 2. Commentaires Utiles vs Inutiles

- ❌ **Interdit** : Commentaires "écho" qui ne font que répéter ce que le code dit (ex: `// set $i to 0`).
- ❌ **Interdit** : Commentaires "mensongers" ou obsolètes. Si le code change, le commentaire DOIT changer.
- ✅ **Obligatoire** : Commentaires sur les zones complexes ou non intuitives (ex: pourquoi un certain calcul est nécessaire, contournement d'un bug système).
- ✅ **Recommandé** : PHPDoc pour documenter les types de retour et les paramètres si ceux-ci ne sont pas explicites par le typage PHP natif.

## 3. Autorisation et Sécurité

- Toute action nécessitant un rôle spécifique (ex: `manager`) doit être protégée par un **Middleware** ou une **Policy**.
- Ne jamais répéter `if (Auth::user()->role !== 'manager')` dans plusieurs méthodes d'un contrôleur.

## 4. Nommage et Typage

- **Classes** : `PascalCase`
- **Méthodes & Variables** : `camelCase`
- **Tables & Dossiers** : `snake_case` (convention Laravel)
- Utilisez les types PHP natifs (String, Int, Void) autant que possible pour les arguments et retours de fonction.

## 5. Exceptions de Qualité

Toute dérogation à ces règles doit être justifiée par un bloc de commentaire explicatif commençant par `[QUALITY-EXCEPTION]`.

## 6. Pipeline CI/CD (US31)

Le projet utilise GitHub Actions pour garantir la fiabilité du code. À chaque Push ou Pull Request sur les branches `main` et `dev`, les vérifications suivantes sont effectuées :

1.  **Installation & Build** : Vérifie que le projet peut s'installer (Composer/NPM) et que les assets sont compilables.
2.  **Qualité du code (Pint)** : Lance un contrôle de style et de linting. Si le style ne respecte pas les standards Laravel, la pipeline échoue.
3.  **Tests Automatisés** : Exécute l'intégralité de la suite de tests (Unit, Feature et Integration). Un seul échec bloque la mise en production.
4.  **Analyse Statique SonarQube (US32)** : Une analyse approfondie du code est réalisée pour détecter les vulnérabilités, les bugs potentiels et les "code smells". Les rapports de couverture de tests sont également remontés à SonarQube.

**Note** : Il est interdit de fusionner une branche si la pipeline est en échec.

# Intégration Continue / Déploiement Continu (CI/CD)

Le projet utilise **GitHub Actions** pour automatiser la vérification de la qualité du code (Linting) et l'exécution de la suite de tests afin d'empêcher les erreurs silencieuses ou de style d'atteindre la branche principale.

## Fonctionnement de la Pipeline

Le fichier de configuration principal est situé ici : `.github/workflows/ci.yml`.

### Événements déclencheurs
Le workflow s'active de manière entièrement automatique sur deux actions principales :
- Un `push` vers les branches principales (`main`, `dev`, `master`).
- L'ouverture ou la mise à jour d'une **Pull Request** visant ces mêmes branches.

### Étapes couvertes (Jobs)

Lorsqu'elle est déclenchée, la pipeline crée un environnement serveur vierge (Ubuntu) puis suit cette procédure :

1. **Préparation :**
   - Téléchargement du code source de la branche actuelle.
   - Installation de PHP 8.2 avec les extensions minimales viables.
   - Installation de Node.js 20.
   - Récupération de l'historique du cache pour accélérer l'installation de Composer et NPM.

2. **Compilation du Frontend :**
   - Lancement de `npm ci` puis `npm run build` via Vite pour s'assurer que les views (Blade/JS/CSS) sont structurellement compilables.

3. **Préparation Backend :**
   - Modélisation de l'environnement Laravel (création du `.env`, création de la base de données de test via SQLite en mémoire, appel de la commande de migration artisan).

4. **Tests et Contrôles (Quality Gates) :**
   - **Vérification du Code (Pint)** : Vérifie le linting PHP. La commande bloquera si le code PHP est indifférent aux normes du projet (`./vendor/bin/pint --test`).
   - **Tests Fonctionnels (PHPUnit)** : Lance toute l'architecture de test de l'application (Assertions d'Authentification, Edge Cases). La pipeline vérifiera que tous les tests passent à 100%.

## Conséquences d'un échec (Pipeline en rouge)

- Tout échec de ce script GitHub signalera la *Pull Request* par une croix rouge.
- Une PR en échec de Pipeline **ne doit pas être fusionnée** sous peine de corrompre le code sur `main`.
- L'équipe technique est encouragée à regarder les logs d'erreurs (onglet "Actions" sous GitHub), puis à corriger le code localement :
  ```bash
  # Optionnel : lancer Pint pour réparer automatiquement la mise en page
  ./vendor/bin/pint
  
  # Obligatoire : Lancer les tests pour valider les correctifs
  php artisan test
  ```
- Enfin, poussez un nouveau commit incluant ces corrections dans votre branche pour relancer automatiquement la vérification.

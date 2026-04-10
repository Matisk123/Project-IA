# Documentation Centrale du Projet IA - Salons & JPO (US37)

Bienvenue sur le dépôt central de l'application de gestion des événements (Salons et Journées Portes Ouvertes). Ce document sert de point d'entrée unique (Single Source of Truth) pour qu'un nouveau membre de l'équipe (ou un jury de soutenance) puisse exécuter, comprendre et exploiter le produit sans devoir chercher l'information à travers de multiples commits ou prompts.

---

## 1. Vision et Périmètre (Scope)

* **Vision :** Digitaliser et simplifier la publication et l'inscription aux événements d'orientation (Salons et JPO) d'une école.
* **Périmètre du MVP (Minimum Viable Product) :**
  * Rôles simplifiés : *Manager* (planification, création) et *Étudiant* (inscription).
  * Backend robuste (Laravel), Base de données légère (SQLite), Environnement standardisé (Docker).
  * *(Pour le détail des arbitrages de ce périmètre, se référer à [`docs/US39_justification.md`](docs/US39_justification.md)).*

---

## 2. Architecture & Référentiels (Index)

Plutôt que d'alourdir ce fichier unique, l'architecture a été découpée et normalisée. Voici les liens directs pour explorer les éléments critiques :
* **Développement & Standards :** [`CODING_STANDARDS.md`](CODING_STANDARDS.md) (Normes PSR, linting).
* **Architecture Base de Données :** Dossier `/database/migrations` (Modèle basé sur les tables `users`, `events` et le pivot `event_user`).
* **Sécurité & SBOM :** [`SECURITY.md`](SECURITY.md) (Règles de sécurité) et [`SBOM.md`](SBOM.md) (Traçabilité des composants).
* **Tests (QA) :** Dossier `/tests` et configuration `phpunit.xml`. L'application dispose de tests automatisés vérifiant le cœur logique.
* **Livraison (CI/CD DevOps) :** [`docs/CI_CD.md`](docs/CI_CD.md) et [`docs/DOCKER.md`](docs/DOCKER.md)
* **Stratégie Git :** [`docs/GIT_STRATEGY.md`](docs/GIT_STRATEGY.md) et [`docs/COMMIT_CONVENTION.md`](docs/COMMIT_CONVENTION.md).
* **Gouvernance IA :** [`docs/AI_AGENT_RULES.md`](docs/AI_AGENT_RULES.md), [`docs/AI_GUARDRAILS.md`](docs/AI_GUARDRAILS.md), et le fichier point d'entrée `/.antigravity.md`.

---

## 3. Installation et Exploitation (Guide de Démarrage)

### A. Prérequis et Configuration des Variables
L'application requiert [Docker](https://docs.docker.com/get-docker/) et [Docker Compose](https://docs.docker.com/compose/install/). 
1. Cloner le projet : `git clone <URL_DU_DEPOT> && cd Project-IA`
2. Configurer les variables d'environnement. Copier le fichier d'exemple :
   ```bash
   cp .env.example .env
   ```
   *Astuce :* Assurez-vous que la variable de la base de données est bien calée sur SQLite : `DB_CONNECTION=sqlite`.

### B. Lancement Conteneurisé (Docker)
C'est la méthode recommandée pour une exploitation locale isolée et fluide.
1. Compiler et démarrer l'infrastructure web :
   ```bash
   docker-compose up -d --build
   ```
2. Accéder à l'application via le navigateur : **[http://localhost:8080](http://localhost:8080)**

### C. Initialisation des Données (US27)
Pour ne pas arriver sur une page blanche, un script peuple la base avec un environnement type. À l'intérieur de notre conteneur (`projet-ia-app`), lancer les migrations :

```bash
docker exec -it projet-ia-app php artisan migrate:fresh --seed
```
Vous disposez désormais de ce jeu de données :
* **Comptes Utilisateurs :**
  * Manager (kohnmatis01@gmail.com) / Mdp: `password`
  * Étudiant Test (student@example.com) / Mdp: `password`
* **État des Événements :** 3 événements nominaux à venir avec inscrits, 1 passé, 1 vide et 5 aléatoires.

*(Pour lancer cette commande sans Docker (en pur local), remplacer le préfixe par la simple commande `php artisan migrate:fresh --seed`)*.

---

## 4. Exploitation et Maintenance au Quotidien

L'exploitation minimale couvre l'arrêt, le suivi d'erreurs et la connaissance des limites du produit.

### A. Démarrage et Arrêt
* Pour stopper brutalement et libérer les ports : `docker-compose down`
* Pour redémarrer de zéro en purgeant les volumes SQLite persistants : `docker-compose down -v`

### B. Suivi des Journaux (Logs)
L'application crache par défaut (`LOG_CHANNEL=stack`) ses erreurs dans un simple fichier d'exploitation localisé ici :
`storage/logs/laravel.log`.
Pour observer les requêtes web du serveur directement, utilisez : `docker-compose logs -f`.

### C. Limites Connues de l'Architecture
Dans un souci de transparence (et suivant notre gouvernance détaillée dans [`docs/US40_preuves_credibilite.md`](docs/US40_preuves_credibilite.md)), ce périmètre reste étudiant. 
Certaines requêtes SQL (pivot) gagneront à être cachées Redis si le site devient massif, et l'assise SQLite devrait migrer vers du MySQL/PostgreSQL configuré en variable `DB_CONNECTION` avant un déploiement Cloud à forte charge. L'absence de tests complets d'intrusion externe (Pentest) demeure également.

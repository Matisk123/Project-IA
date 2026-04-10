# US40 - Preuves de Crédibilité Professionnalisante

Ce document a été rédigé à l'attention du Jury de soutenance. Il centralise, indexe et prouve la crédibilité de la démarche projet ("Enterprise-ready"), afin de démontrer que le développement ne s'est pas limité à la simple génération de code, mais a intégré l'ensemble des bonnes pratiques d'ingénierie logicielle.

---

## 1. Cartographie des Preuves : Produit, Ingénierie et Gouvernance

Chaque axe de professionnalisation possède un ou plusieurs livrables tangibles dans le projet :

### A. DevOps, Déploiement et CI/CD
L'application ne repose pas sur de simples commandes manuelles, mais s'inscrit dans une démarche d'intégration et de livraison continue (DevOps).
* **Preuve 1 - Conteneurisation :** Présence d'un `Dockerfile` et d'un `docker-compose.yml` garantissant l'unification des environnements et l'isolation des services.
* **Preuve 2 - Documentation d'Infrastructure :** Le fichier [`docs/DOCKER.md`](DOCKER.md) structure la gestion des conteneurs.
* **Preuve 3 - Pipelines et Qualité Continue :** Le fichier [`docs/CI_CD.md`](CI_CD.md) définit la chaîne d'intégration automatique pour éviter le déploiement de code cassé.

### B. Contrôle Qualité et Tests (QA)
Un produit industriel exige des standards vérifiables.
* **Preuve 1 - Standards de code :** Le document [`CODING_STANDARDS.md`](../CODING_STANDARDS.md) dicte de manière transparente les normes suivies (syntaxe, architecture).
* **Preuve 2 - Suite de Tests :** Présence du dossier `/tests` et du fichier `phpunit.xml`. Des tests automatisés (Feature Tests et Unit Tests) de la logique métier ont été mis en place pour éviter la régression.

### C. Sécurité et Conformité
La culture de la donnée est au cœur des enjeux actuels.
* **Preuve 1 - Politique de Sécurité :** Un fichier synthétique [`SECURITY.md`](../SECURITY.md) fixe le cadre de gestion des failles et de durcissement.
* **Preuve 2 - Nomenclature des Dépendances (SBOM) :** Les fichiers [`SBOM.md`](../SBOM.md), `sbom_backend.json` et `sbom_frontend.json` prouvent la traçabilité complète des packages et le suivi de la "Software Supply Chain", un standard vital de l'industrie.

### D. Gestion de Code et Stratégie Git
* **Preuve 1 - Convention de Commits :** Référentiel [`docs/COMMIT_CONVENTION.md`](COMMIT_CONVENTION.md) pour standardiser l'historique (type de commit : feat, fix, chore...).
* **Preuve 2 - Politique de Branches :** Le fichier [`docs/GIT_STRATEGY.md`](GIT_STRATEGY.md) explicite un flux de travail non-destructif.

### E. Gouvernance IA
L'usage de l'Intelligence Artificielle en entreprise pose des enjeux de fuite de données et d'architecture. Notre projet l'a anticipé.
* **Preuve 1 - Fichier racine d'instruction IA :** [`../.antigravity.md`](../.antigravity.md) régule le périmètre de l'assistant IA déployé.
* **Preuve 2 - Garde-Fous et Règles strictes :** Les fichiers [`docs/AI_GUARDRAILS.md`](AI_GUARDRAILS.md) et [`docs/AI_AGENT_RULES.md`](AI_AGENT_RULES.md) prouvent que l'IA est gouvernée de manière volontaire et sécurisée, et non subie.

---

## 2. Limites du Projet Étudiant et Écarts avec l'Industrie

Développer un produit de manière scolaire entraîne évidemment des contraintes temporelles et logistiques. Plutôt que de les masquer, l'approche professionnelle consiste à identifier et documenter ces futures améliorations (Dette technique) :

1. **Tests et Validation en Conditions Réelles (Load Testing) :** 
   * *La limite :* Notre application n'a pas été éprouvée sous très forte charge (ex: milliers d'étudiants s'inscrivant la même minute via JMeter / Gatling).
   * *Au niveau industriel :*  Des tests de montée en charge seraient systématiques avant le lancement d'une JPO d'envergure.

2. **Hébergement et Scalabilité (K8s/Cloud Natif) :** 
   * *La limite :* La base de données est actuellement en SQLite (voir les arbitrages sur la US39), sans clusters de haute disponibilité.
   * *Au niveau industriel :* Le système évoluerait vers une infrastructure orchestrée avec Kubernetes, RDS d'AWS ou équivalent, couplé avec PostgreSQL/MySQL.

3. **Sécurité (Audit / Pentesting) :**
   * *La limite :* Les vulnérabilités sont surveillées via les bonnes pratiques du framework Laravel, et les SBOM ont été créés, mais aucun test d'intrusion externe (Pentest) n'a été mené.
   * *Au niveau industriel :* Une entreprise ferait valider ce livrable par un auditeur en cybersécurité ou un Bug Bounty, afin de chasser de potentielles failles sur les Middlewares ou la Session.

4. **CI/CD Actif (Hébergé) :**
   * *La limite :* Les pipelines sont théorisés et présents localement (Docker/Makefile), mais ne déclenchent pas un vrai déploiement sur une architecture infonuagique tierce.

## 3. Conclusion : Un Socle Viable

Bien que ces limites soient pleinement identifiées, la cartographie des Preuves montre que **l'intégralité du cycle de vie du produit** a été adressée avec un souci d'exigence et de méthode quasi professionnel (Sécurité, SBOM, Gouvernance IA, Git, Tests, Standardisation). Le cœur de la structure mise en place dans ce prototype **est fait pour survivre à grande échelle** et passer sereinement entre les mains d'une vraie équipe d'ingénieurs.

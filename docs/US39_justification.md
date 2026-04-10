# US39 - Justification des arbitrages, compromis et priorités du backlog

Ce document vise à expliciter les choix techniques et fonctionnels réalisés tout au long du développement du projet de gestion des Salons et JPO, afin de démontrer que le backlog est un outil de pilotage réfléchi et non une simple liste de tâches.

## 1. Les 5 Arbitrages Majeurs

Voici l'explication structurée de 5 arbitrages majeurs avec le bénéfice attendu et le coût associé :

### Arbitrage 1 : Utilisation de SQLite au lieu de PostgreSQL/MySQL
* **Choix :** Déployer le MVP avec SQLite (comme précisé dans l'initialisation Docker).
* **Bénéfice attendu :** Une installation locale et via Docker extrêmement rapide, sans configuration complexe de service de base de données. Idéal pour un MVP orienté preuve de fonctionnement.
* **Coût associé :** Perte de scalabilité immédiate. Une migration vers un SGBD plus robuste sera nécessaire si le trafic ou le volume de données augmente significativement dans le futur.

### Arbitrage 2 : Modèle de rôles simplifié (Manager / Étudiant)
* **Choix :** Implémenter un système de rôles basique via un champ `role` dans la table `users`, plutôt qu'un système de permissions dynamique (RBAC très abouti via Spatie par exemple).
* **Bénéfice attendu :** Gain de temps de développement de l'ordre de plusieurs jours. Couvre 100% des besoins du MVP pour la séparation des droits entre créateurs d'événements et participants.
* **Coût associé :** Moins de flexibilité. Si un nouveau profil (ex: "Professeur" ou "Ancien Élève") nécessite des permissions hybrides, le code logique devra être repris.

### Arbitrage 3 : Front-end Monolithique vs. SPA (Single Page Application)
* **Choix :** Conserver un rendu côté serveur (SSR) avec Blade/Vite fourni par Laravel, plutôt que de séparer en back-end API et front-end React/Vue complexe.
* **Bénéfice attendu :** Réduction drastique de la complexité architecturale pour l'équipe (délai respecté). Le référencement (SEO) et le temps de premier chargement sont nativement meilleurs sans configuration additionnelle.
* **Coût associé :** Une ergonomie très légèrement en retrait (rafraîchissement entier de certaines pages) par rapport à une SPA ultra-fluide.

### Arbitrage 4 : Dockerisation pour l'environnement de développement
* **Choix :** Prioriser la création d'un `docker-compose.yml` complet pour uniformiser les environnements locaux.
* **Bénéfice attendu :** Fin du syndrome "ça marche sur ma machine". Qualité de développement améliorée, fiabilité des tests, et onboarding des jurys/nouveaux développeurs grandement facilité.
* **Coût associé :** Investissement de temps non-négligeable initialement pour configurer et maintenir l'environnement Docker, au détriment potentiel du développement de fonctionnalités métiers mineures.

### Arbitrage 5 : Seeders complets et réalistes en amont
* **Choix :** Intégrer très tôt des scripts d'initialisation de données complets (via `php artisan migrate:fresh --seed`) contenant à la fois des cas nominaux (événements remplis) et d'erreurs (états vides ou passés).
* **Bénéfice attendu :** Les testeurs, futurs utilisateurs, ou encore le jury de la soutenance peuvent immédiatement expérimenter l'application sans créer au préalable tout un écosystème de faux contenu, accélérant ainsi la validation des Users Stories (US).
* **Coût associé :** Maintenance constante des factories et seeders lors des changements structurels de la base de données.

---

## 2. Synthèse des Compromis : Délai, Qualité, Sécurité, Périmètre et Ergonomie

L'équilibre stratégique du projet s'est construit autour de plusieurs compromis vitaux :
* **Délai vs Périmètre :** Pour garantir nos délais de livraison de ce MVP fonctionnel, le périmètre a été drastiquement circonscrit autour de l'essentiel (la gestion des événements et de la participation des étudiants). Les fonctionnalités "Nice to have" ont été sciemment identifiées pour le backlog futur.
* **Qualité & Sécurité vs Ergonomie :** Nous avons privilégié un socle très sécurisé (gestion des accès stricte, respect absolu des standards de code comme défini dans `CODING_STANDARDS.md` et interdictions IA définies dans `AI_GUARDRAILS.md`) au prix de quelques compromis sur les animations front-end ou autres ajouts purement cosmétiques. La robustesse et la pérennité du projet passent avant le spectaculaire visuel.

---

## 3. Lien des Stories Prioritaires avec le Problème, les Personas et le MVP

Les stories les plus prioritaires du backlog (celles qui figurent dans les Sprints initiaux) se concentraient exclusivement sur la résolution des besoins fondamentaux de nos deux Personas clés :
* **Le "Manager" (ex: Profil organisateur / kohnmatis01)** : Son problème de fond est de planifier, ajuster et exposer les événements (Salons, JPO) de manière optimale. Il devait pouvoir créer/supprimer sans erreur.
* **L'"Étudiant" (ex: Participant Test)** : Son problème est de pouvoir s'informer rapidement concernant les événements existants, s'y inscrire et pouvoir attester de sa présence. 

Ces US fondatrices forment la colonne vertébrale du projet : le **MVP** (Minimum Viable Product). S'il est impossible de créer un événement et de s'y inscrire de manière sécurisée et fluide, l'application ne délivre pas sa promesse.

---


*L'intégralité du pilotage Agile s'est donc conformée à un pragmatisme constant : livrer avant tout de la valeur métier vérifiable, sécuriser un standard d'architecture (Docker, typage, tests), et assumer clairement la dette technique secondaire renvoyée aux prochaines itérations.*

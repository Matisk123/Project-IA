# Garde-Fous Qualité et Sécurité des Agents IA (US21)

Afin de prévenir tout code fragile, l'introduction de failles de sécurité, l'apparition de régressions ou la création de dette technique silencieuse, les agents IA impliqués dans le développement sont soumis aux garde-fous strictement détaillés ci-dessous avant de proposer ou de valider le moindre livrable.

## 1. Contrôles Qualité et Tests (Quality Gates)
- **Prouver le fonctionnement global** : Tout code proposé, même mineur, doit pouvoir être vérifié contre des critères explicites de qualité et de normes de code (alignés virtuellement ou matériellement sur les exigences d'outils comme SonarQube, PHPStan, ou ESLint).
- **Signalements stricts et impératifs** : 
  - L'agent IA doit examiner chaque modification et signaler *immédiatement* s'il vient de créer ou s'il s'apprête à créer une forme de **dette technique** non résolue.
  - L'IA doit expliciter tout **manque de test** potentiel et tout **risque de régression** dans le comportement fonctionnel de base qu'auraient ses suggestions. Tout oubli volontaire de test doit déclencher une alerte visuelle et demander l'approbation humaine.

## 2. Sécurité des Données et Dépendances
- **Absence de secrets en dur (Hardcoded Secrets)** : L'IA doit lancer une ultime passe de vérification mentale confirmant l'absence stricte de secrets (mots de passe utilisateur, clés d'API externes, tokens de chiffrement, tokens d'accès) laissés en dur dans le code proposé. L'IA utilisera obligatoirement les variables d'environnement (`.env` ou équivalent Laravel) ou s'en abstiendra.
- **Droits excessifs et Sécurisation RBAC** : La proposition ou modification de middlewares, de politiques d'autorisation ou de droits utilisateurs ne doit jamais être configurée sur "excessif" par l'IA dans un but de "simplicité" ou de "succès des tests". Une politique stricte du "moindre privilège" reste la seule stratégie de gouvernance par défaut.
- **Dépendances additionnelles justifiées** : Tout ajout de dépendance (Composer packages, bibliothèques Node, scripts distants) doit faire l'objet du signalement explicite des avantages contre le poids additionnel ou le risque de sécurité. Les dépendances non justifiées sont bloquées.

## 3. Alignement Structurel et Cohérence Technique
- Ces garde-fous doivent s'évaluer en harmonie complète avec les procédures de la [Stratégie Git (US17)](GIT_STRATEGY.md) et la [Convention de Commits (US18)](COMMIT_CONVENTION.md).
- Si l'un de ces marqueurs passe dans le rouge dans les propositions d'Antigravity, la responsabilité formelle de l'IA est d'en alerter l'Architecte Logiciel ou le développeur à la manœuvre.

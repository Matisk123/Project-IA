# Convention de Commits et Découpage Atomique

Pour assurer une traçabilité lisible des évolutions et faciliter les revues de code, le projet s'appuie sur des règles strictes concernant les commits.

## 1. Format des Messages de Commit

Le projet utilise les standards des [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/).

**Format obligatoire :**
```
<type>([scope optionnel]): <description courte>

[corps optionnel pour développer le contexte ou la justification]
```

**Préfixes autorisés :**
- `feat` : Ajout d'une nouvelle fonctionnalité métier ou UI
- `fix` : Correction d'un bug détecté
- `docs` : Création ou mise à jour de la documentation (README, fichiers markdown, commentaires système)
- `style` : Changements liés uniquement au formatage du code sans impact sur la logique d'exécution (espaces, retraits, typographie)
- `refactor` : Modification du code de production existant sans ajout de fonctionnalité ni correction de bug
- `perf` : Optimisation ayant pour effet d'améliorer les performances du système
- `test` : Ajout de nouveaux tests ou modification des tests existants
- `chore` : Tâches d'infrastructure, de maintenance, de mise à jour de bibliothèques internes, sans modification de l'application

**Exemples acceptés :**
- `feat(events): ajout du formulaire de création d'un événement JPO`
- `fix(auth): correction du problème de redirection après connexion`
- `docs: mise à jour de la documentation Git (US17)`

## 2. Granularité et Découpage Atomique

- **Un commit = Un sujet** : Un commit ne doit en aucun cas mélanger volontairement plusieurs sujets sans lien. Séparez les modifications indépendantes en plusieurs commits distincts.
- **Principe du "One per Feature"** : Chaque ajout de fonctionnalité ou correction de bug spécifique fait l'objet d'au minimum un commit dédié.
- **Justification et traçabilité** : Les commits qui modifient, suppriment ou ajoutent du code fonctionnel de l'application doivent inclure les tests modifiés. S'il n'y a pas de tests joints en l'état, une brève justification devra obligatoirement apparaître dans la description du commit ou au sein de la Pull Request associée.

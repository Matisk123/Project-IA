# Exécution et Conteneurisation (Docker)

Le parcours de livraison du projet a été standardisé sous forme de Conteneur Docker (US35).

## Pourquoi un conteneur ?
Le `Dockerfile` à la racine de l'application utilise une approche dite "Multi-Stage". L'avantage principal est qu'il isole complètement le serveur de production (qui embarque Apache et PHP 8.2) des outils de développement lourds (Node.js et PHPUnit/Composer Dev Dependencies).
Cela permet d'avoir une image web de production "exécutable de bout en bout", légère, hautement sécurisée, et sans outillage indésirable côté serveur.

## Comment compiler localement ?

Pour générer cette image (processus qui dure une à deux minutes la première fois) :

```bash
docker build -t projet-ia-app .
```

Si vous voulez l'exécuter localement "à la main" :

```bash
docker run -p 8080:80 -d projet-ia-app
```

## Orchestration Rapide

Pour bénéficier du setup **One-Click** :

```bash
# Démarre tout, compile si besoin, et migre la base de données automatiquement
docker-compose up -d
```

L'application sera accessible sur http://localhost:8080 dès que le conteneur sera "Up".

## Base de données SQLite
Lors du démarrage, le conteneur vérifie automatiquement l'état de la base de données. Si de nouvelles migrations sont présentes, elles sont appliquées immédiatement de manière sécurisée (`migrate --force`).
Un volume nommé `sqlite-data` est utilisé pour la persistence.

### Optionnel : Peupler la base (Seeds)
Si vous souhaitez ajouter des données de test par défaut après le premier démarrage :
```bash
docker-compose exec app php artisan db:seed
```

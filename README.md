<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Initialisation des données (US27)

Pour charger le jeu de données de démonstration et de test, utilisez les commandes suivantes :

```bash
# Pour une installation propre avec données de test
php artisan migrate:fresh --seed
```

### Contenu du jeu de données :
- **Utilisateurs** :
    - Manager : `kohnmatis01@gmail.com` (Matis Kohn)
    - Étudiant Test : `student@example.com`
    - Mot de passe par défaut : `password`
- **Événements** :
    - **Usage Nominal** : 3 événements à venir (Salons et JPO) avec des inscrits.
    - **Cas d'erreur / Historique** : 1 événement passé terminé.
    - **État vide** : 1 événement sans aucun participant.
    - **Données aléatoires** : 5 événements supplémentaires pour peupler l'interface.

## Installation avec Docker

Ce projet inclut une configuration Docker permettant de lancer l'application facilement, sans avoir à installer PHP ou SQLite directement de manière locale.

### Prérequis
- [Docker](https://docs.docker.com/get-docker/) installé.
- [Docker Compose](https://docs.docker.com/compose/install/) installé (inclus avec Docker Desktop).

### Étapes d'installation

1. **Cloner le dépôt** (si ce n'est pas déjà fait) :
   ```bash
   git clone <URL_DU_DEPOT>
   cd Project-IA
   ```

2. **Démarrer l'application avec Docker Compose** :
   Pour construire l'image et lancer le conteneur en arrière-plan, exécutez à la racine du projet :
   ```bash
   docker-compose up -d --build
   ```

3. **Initialiser la base de données (Migrations & Seeders)** :
   Une fois le conteneur démarré (`projet-ia-app`), vous devez lancer les migrations et injecter les données de test à l'intérieur du conteneur :
   ```bash
   docker exec -it projet-ia-app php artisan migrate:fresh --seed
   ```

4. **Accéder à l'application** :
   L'application est désormais fonctionnelle et exposée sur le port `8080`. Ouvrez votre navigateur et accédez à :
   [http://localhost:8080](http://localhost:8080)

### Arrêter l'application

Pour stopper les conteneurs (la base de données SQLite est persistée via un volume Docker, vos données ne seront pas perdues) :
```bash
docker-compose down
```

# Inventaire des Dépendances & SBOM - Project IA

Ce document constitue la nomenclature logicielle (Software Bill of Materials) du projet de gestion d'événements de la Coding Factory (US34).

## 1. Inventaire des composants Critiques

### 🔙 Backend (PHP/Laravel)

| Composant | Utilité | Justification |
| :--- | :--- | :--- |
| **laravel/framework** | Cœur Applicatif | Framework MVC standard pour le projet. |
| **laravel/tinker** | Console Interactive | Utilisé pour le débogage et le seeding. |
| **laravel/breeze** | Authentification | Fournit le système complet de login/register sécurisé. |
| **fakerphp/faker** | Génération de données | Crucial pour l'US27 (Données de démo). |

### 🎨 Frontend (JS/CSS)

| Composant | Utilité | Justification |
| :--- | :--- | :--- |
| **alpinejs** | Réactivité | Framework JS léger pour l'interface utilisateur. |
| **tailwindcss** | Design & CSS | Utilisé pour l'esthétique premium du projet. |
| **vite** | Compilation Assets | Standard moderne pour le build des assets Laravel. |
| **axios** | Requêtes HTTP | Utilisé pour les interactions client-serveur. |

## 2. Analyse de Pertinence

- **Nettoyage** : Toutes les dépendances listées dans `composer.json` et `package.json` sont activement utilisées. Aucune bibliothèque redondante n'a été conservée (ex: pas de Lodash si AlpineJS suffit).
- **Audit de sécurité** : L'audit automatisé via `composer audit` et `npm audit` doit être lancé avant chaque mise en production majeure.

## 3. Procédure de Régénération de la SBOM

Pour produire une nomenclature logicielle à jour dans un format standard (JSON), utilisez les commandes suivantes :

```bash
# Générer la SBOM Backend
composer show --format=json > sbom_backend.json

# Générer la SBOM Frontend
npm list --json > sbom_frontend.json
```

Ces fichiers peuvent ensuite être intégrés dans des outils de gestion de vulnérabilité (SCA) comme Dependency-Check ou OWASP Dependency-Track.

## 4. Vigilance sur les vulnérabilités known limits
- **PHP** : Rapports de sécurité via [Packagist Safety Advisories](https://packagist.org/api/security-advisories/).
- **JS** : Alertes régulières via `npm audit fix` pour les vulnérabilités de bas niveau.

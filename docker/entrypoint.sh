#!/bin/sh
set -e

# S'assurer que le fichier SQLite existe avec les bonnes permissions
if [ ! -f "/var/www/html/database/database.sqlite" ]; then
    echo "Création de la base de données SQLite..."
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# Exécuter les migrations de manière forcée
echo "Exécution des migrations..."
php artisan migrate --force --no-interaction

# On peut aussi lancer le seeding ici si besoin (commenté par défaut pour éviter les doublons en prod)
# php artisan db:seed --force

# Lancer la commande passée en argument (par défaut apache2-foreground)
exec "$@"

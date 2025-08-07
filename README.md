# Photography Website

The code for my personal photography website, accessible at [photography.schlachter.xyz](https://photography.schlachter.xyz).

## Installation

Prerequisites: PHP, Composer, and NPM/Node

```sh
# Pull from github
git clone git@github.com:mschlachter/photography.git
cd photography

# Install dependencies
composer install
npm install

# Start dev server
composer run dev
```

## Update Script

```sh
# Turn on maintenance mode
php artisan down

# Pull the latest changes from the git repository
git merge

# Install/update composer dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear

# Clear expired password reset tokens
php artisan auth:clear-resets

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Restart queues
php artisan queue:restart

# Turn off maintenance mode
php artisan up
```

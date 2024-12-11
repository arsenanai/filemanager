# Entries checking project
## Server requirements
- Everything that is required by Laravel v11

## Installation guide
Guide was documented while using Laravel v11

- create an `.env` file and fullfill it
- Run commands 
```sh
composer install
npm install
npm run build
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

For local development server:
```sh
php -S localhost:8000 -t public
```

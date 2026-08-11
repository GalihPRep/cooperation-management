# Note
After the installation, files uploaded into this app won't be accessible at first. To make it accessible, link `./storage/app/public` with `./public/storage` by running the following on the terminal:
```
php artisan storage:link
```
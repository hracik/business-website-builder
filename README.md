# Business web builder

Create simple business website with admin area and couple of settings.

Possibility to use:
* contact form
* bank accounts
* crypto-currency accounts
* service accounts

## Installation
Install with:
```
git init
git add remote origin https://github.com/hracik/business-website-builder.git .
git pull origin master
composer install
```

Create file `.env.local` Copy content from `.env.example` - use your own secrets and settings.

Create SQLite database with:
```
php bin/console doctrine:migrations:migrate
```
or
```
symfony doctrine:migrations:migrate
```

To create user use:
```
php bin/console app:create-user
```
or
```
symfony app:create-user
```

***
Now you can go to URL where you installed the code and build your business website.
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
composer require hracik/business-website-builder
composer install
```

Create file `.env.local` Copy content from `.env.example` - use your own secrets and settings.

Create SQLite database with:
```
symfony doctrine:migrations:migrate
```

To create user use:

```
symfony app:create-user
```



***
Now you can go to URL where you installed the code and build your business website.
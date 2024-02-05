# The Compendium

This is a project to rebuild the [Disney Compendium](https://www.ilsollazzo.com/c/disney) from scratch.

It is under heavy development.

The current main goal is to import the SQLite - based database in a new (and better designed) MariaDB database.

## Installation

The Compendium is a Laravel based project. It requires a LAMP environment with php8.2 and MariaDB. It will eventually
support Docker.

After cloning the project, you simply need to install the libraries via [composer](https://getcomposer.org/).

```shell
git clone https://github.com/ilsollazzo/compendium.git
cd compendium
composer install
```

Once installed the project, you need to copy the `.env.example` file to `.env`, configure the MariaDB database host and
credentials and run:

```shell
php artisan key:generate
php artisan db:seed --migrate
```

## Importing the old database

If you need to import the old SQLite database, you can place it in the `database/` directory, and set its name on the
`DB_OLD_FILENAME` parameter in the `.env` file, and run:

```shell
php artisan compendium:import-old-db
```

**IT WILL DESTROY ANY DATA IN THE DATABASE**

## Conventions

This repository use [gitmoji](https://gitmoji.dev/) shortcodes.

In this heavy development phase, the `main` branch is a mess. We'll have a separate `dev` branch when we'll release.

# USAT Benin — Symfony 5.4 application

## Overview

A Symfony 5.4 web application used by USAT Benin. This repository contains the PHP backend (Symfony), frontend assets built with Webpack Encore, and a MySQL database dump (database.sql) to populate a working dataset for local testing.

This README documents how to get the project running, using Yarn to manage frontend assets (Node v14), Composer for PHP dependencies, and the provided SQL dump to populate the database.

### Highlights
- Symfony 5.4 application (composer.json requires Symfony 5.4)
- PHP requirement: ^8.2 (see composer.json)
- Frontend built with Webpack Encore. Node.js v14 is expected for the existing build config.
- Yarn is used for frontend tasks
- A full MySQL dump is included at database.sql with many pre-populated users and data for testing

### Quick status / checklist
- [x] PHP dependencies: composer install
- [x] JS dependencies & assets: yarn && yarn dev (or yarn dev-server for live rebuilds)
- [x] Database: import database.sql (MySQL example included)
- [x] Run app: symfony server:start OR php -S

### Prerequisites
- PHP 8.2+ and the usual PHP extensions (see composer.json "require" section). Install via Homebrew or your preferred method.
- Composer (https://getcomposer.org)
- Node.js v14.x (the project was developed against Node v14; newer Node may work but can cause node-sass or native build issues)
- Yarn (https://yarnpkg.com/)
- MySQL 5.7+ (recommended for importing the provided SQL dump)
- (Optional but recommended) Symfony CLI (symfony) for an easy local web server: https://symfony.com/download

### Repository-specific scripts
Exact values taken from package.json and composer.json)
- Yarn scripts (package.json)
    - dev-server: encore dev-server
    - dev: encore dev
    - watch: encore dev --watch
    - build: encore production --progress

- Composer scripts (composer.json)
    - auto-scripts: runs cache:clear and assets:install (%PUBLIC_DIR% resolved by Symfony flex)
    - post-install-cmd / post-update-cmd: calls @auto-scripts

- The included database.sql is a MySQL dump. The examples below show how to import it into a MySQL database. If you want to use Doctrine migrations instead, see the "Database / Migrations" section.

## Installation (development)

### 1. Clone the repository
```shell
  git clone <repository-url>
  cd usat_benin
```

### 2. Copy environment file and configure
```shell
  cp .env.example .env.local
```

Edit `.env.local` and set your DATABASE_URL and other variables. Example (MySQL):
```
  DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/usat_benin?serverVersion=5.7"
```

Note: composer.json includes auto-scripts that will run assets:install after composer install. The default public dir for this project is `public`.

### 3. Install PHP dependencies (Composer)
```shell
  composer install
```

This runs the post-install auto-scripts which will clear cache and run assets install.

### 4. Install JS dependencies (Yarn)
```shell
  yarn
```

Note: the repo uses Webpack Encore. It has been developed using Node v14; if you have trouble building with newer Node, switch to Node 14 using nvm or similar.

## Build frontend assets

- Development (fast, unminified):
```shell
  yarn dev
```

- Development with dev-server (hot reloading; runs a webpack dev server)
```shell
  yarn dev-server
```

- Watch mode (rebuild on change):
```shell
  yarn watch
```

- Production (minified):
```shell
  yarn build
```

The compiled assets are written to `public/build/` (configured in webpack.config.js).

## Database / Importing the provided dump

The project includes `database.sql` at the repository root. It's a MySQL dump that contains schema + data.

### 1) Create an empty database (MySQL example):

#### login to mysql and create database
```shell
  mysql -u root -p
  CREATE DATABASE usat_benin DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  exit
```

### 2) Import the dump:
```shell
  mysql -u root -p usat_benin < database.sql
```

### 3) Update `.env.local` to point to your DB (DATABASE_URL). Example:
```
  DATABASE_URL="mysql://root:yourpassword@127.0.0.1:3306/usat_benin?serverVersion=5.7"
```

Alternative: if you'd rather run Doctrine migrations from scratch (no dump), update DATABASE_URL to your DB, create the DB and run:
```shell
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
```

Note: the SQL dump already contains inserted data and the doctrine_migration_versions table; if you import the SQL, you don't need to run migrations.

## Running the app (local development)

### Option A — Symfony CLI (recommended)

##### start Symfony local server (from project root)
```shell
  symfony server:start --allow-http
```

#### open in browser
```shell
  symfony open:local
```

### Option B — Built-in PHP server
```shell
  php -S 127.0.0.1:8000 -t public
```

If you run the webpack dev-server (yarn dev-server), start it in a separate terminal so assets are served by the dev server while Symfony serves backend routes.


## Running tests

This project includes PHPUnit (symfony/phpunit-bridge). Run tests with the provided binary:
```shell
  ./bin/phpunit
```


## Troubleshooting

- node-sass / native build errors: If you run into build errors when running `yarn` or `yarn dev` related to node-sass, ensure you run Node v14 (use nvm: `nvm install 14 && nvm use 14`).
- Permissions: If you get permission errors for `var/` or `public/` directories, set writable permissions: `sudo chown -R $(whoami) var public` and ensure the web server user has access.
- Database connection issues: Ensure DATABASE_URL in `.env.local` is correct. If you imported the SQL dump, make sure the DB name matches the DATABASE_URL.
- Encore dev-server connectivity: If `yarn dev-server` serves assets on a different port, ensure your templates reference the correct `asset` paths (Encore should handle this automatically). If using the Symfony local proxy, it should proxy requests correctly.

## Useful commands (summary)

- PHP dependencies: composer install
- JS dependencies: yarn
- Dev assets: yarn dev
- Dev assets with dev-server (hot reload): yarn dev-server
- Watch assets: yarn watch
- Production assets: yarn build
- Run local web server: symfony server:start OR php -S 127.0.0.1:8000 -t public
- Run tests: ./bin/phpunit
- Doctrine migrations: php bin/console doctrine:migrations:migrate
- Doctrine schema update (not recommended for production): php bin/console doctrine:schema:update --force

## Security / notes

- This repository contains a SQL dump with hashed passwords and seeded data for development/testing. Do not use these credentials in production.
- The composer.json license is proprietary; confirm licensing requirements before redistribut
## License

This repository is marked as proprietary in composer.json. See the LICENSE file in the repository for details.

## Maintainer / Contact

For questions about the repository, contact the repository owner/maintainer (provided in the project).


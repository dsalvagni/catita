# Catita [![CircleCI](https://circleci.com/gh/dsalvagni/catita.svg?style=svg)](https://circleci.com/gh/dsalvagni/catita)

This is a work logger/time tracking app.

## Quick start

### DB
In the `scripts` folder you will find all SQL scripts to create the database and a user and his permissions for each environment.

-----

### API
Clone this repository.

> composer install

Rename `.env.sample` to `.env` and add real configuration.

> php artisan migrate

> php artisan db:seed

> php -S localhost:8000 -t public

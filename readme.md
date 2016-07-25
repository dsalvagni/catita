# Catita 

This is a work logger/time tracking app.

## Quick start

### DB

#### Development
````SQL
CREATE DATABASE 'catita_development';
````
````SQL
CREATE USER 'catita_dev'@'localhost' 
IDENTIFIED BY 'secret';
```` 
````SQL
GRANT ALL ON catita_development.* 
TO 'catita_test'@'localhost';
````
#### Testing
````SQL
CREATE DATABASE 'catita_testing';
````
````SQL
CREATE USER 'catita_test'@'localhost' 
IDENTIFIED BY 'secret';
````
````SQL
GRANT ALL ON catita_testing.* 
TO 'catita_test'@'localhost';
````

-----

### API
Clone this repository.

> composer install

Rename `.env.sample` to `.env` and add real configuration.

> php artisan migrate

> php artisan db:seed

> php -S localhost:8000 -t public

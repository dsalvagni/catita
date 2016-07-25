# Catita 

This is a work logger/time tracking app.

## Quick start

### API
Clone this repository.

> composer install

Rename `.env.sample` to `.env` and add real configuration.

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
CREATE DATABASE IF NOT EXISTS  catita_development;
CREATE USER 'catita_dev'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL ON catita_development.* TO 'catita_test'@'localhost';

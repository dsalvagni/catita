CREATE DATABASE IF NOT EXISTS catita_testing;
CREATE USER 'catita_test'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL ON catita_testing.* TO 'catita_test'@'localhost';

CREATE DATABASE IF NOT EXISTS catita_staging;
CREATE USER 'catita_stag'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL ON catita_staging.* TO 'catita_stag'@'localhost';

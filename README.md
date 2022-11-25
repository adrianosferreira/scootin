# Scootin' Aboot

Implementation details about the REST API created for the Scootin' Aboot

## Summary of technologies used:

- Laminas framework
- ELK stack
- PHPUnit
- PHP CodeSniffer
- Doctrine ORM
- Doctrine Migrations
- Docker
- Composer
- Swagger

## How to run the project

- Clone the project 
- Build and start docker containers
  - `docker-compose up -d`
- Run composer
  - `docker exec php-fpm composer install`
- Run the migrations
  - `docker exec php-fpm ./vendor/bin/doctrine-migrations migrate`
- Kibana running at http://localhost:5601 username: elastic | password: password
- REST API running at http://localhost:8080
- Swagger Documentation running at http://localhost:9001
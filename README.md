# Scootin' Aboot

[![Unit Tests / PHPStan](https://github.com/adrianosferreira/scootin/actions/workflows/php.yml/badge.svg)](https://github.com/adrianosferreira/scootin/actions/workflows/php.yml)

Implementation details about the REST API created for the Scootin' Aboot

## Summary of technologies used:

- Laminas framework
- ELK stack
- PHPUnit
- PHP CodeSniffer
- PHPStan
- Doctrine ORM
- Doctrine Migrations
- Docker
- Composer
- Swagger
- Basic Authentication
- Basic CI pipeline for running PHPUnit Tests and PHPStan (Github Actions)
- Guzzle for dispatching HTTP requests
- Symfony Command for the CLI which will act as fake mobile users

## How to run the project

- Clone the project 
- Build and start docker containers
  - `docker-compose up -d`
- Run composer
  - `docker exec php-fpm composer install`
- Run the migrations
  - `docker exec php-fpm ./vendor/bin/doctrine-migrations migrate`

## Available URLs

- REST API running at http://localhost:8080
- Kibana running at http://localhost:5601 username: elastic | password: password
- Swagger Documentation running at http://localhost:9001

## Extra notes

I've used basic authentication for all endpoints here and a single user is stored in the apikeys table: username is "mobile" and password is "oZq!63ydPHB0".

I've written only a few unit tests for the Scooter module.
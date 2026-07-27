# lasas

This project is dedicated to experiment on drupal framwework.

## docker

    docker network create lasas-network

    cp xdebug.ini.example xdebug.ini

    docker compose up -d

Enter the docker container command line:

    docker exec -itu 1000:1000 lasas bash

## tests

Run the PHPUnit tests (e.g. the meteo_client module tests):

    docker compose exec -u 1000:1000 lasas bash -c "cd app/web/core && ../../vendor/bin/phpunit -c . ../modules/custom/meteo_client/tests/src/Unit/MeteoClientSmokeTest.php"


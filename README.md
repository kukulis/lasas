# lasas

This project is dedicated to experiment on drupal framwework.

## docker

    docker network create lasas-network

    cp xdebug.ini.example xdebug.ini

    docker compose up -d

Enter the docker container command line:

    docker exec -itu 1000:1000 lasas bash

Run the composer:

    cd app
    composer install

### drupal configuration

    chmod a+w -R web/sites/default
    cp web/sites/default/default.settings.php web/sites/default/settings.php


In the browser when you input http://localhost/7088 the setup process should start.
When the setup process reaches "Set up database" step, input following values: 

Database name: lasas_db
Database username: lasas
Database password: lasas_password
Advanced options ->
Host: lasas_db




## tests

Run the PHPUnit tests (e.g. the meteo_client module tests):

    docker compose exec -u 1000:1000 lasas bash -c "cd app && vendor/bin/phpunit -c web/core/phpunit.xml.dist web/modules/custom/meteo_client/tests/src/Unit/MeteoClientSmokeTest.php"


## drush errors log

    vendor/bin/drush watchdog:show --severity=Error --count=15


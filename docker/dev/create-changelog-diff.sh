#!/bin/bash

docker exec -it $(docker-compose ps -q mysql | head -1) /bin/bash -c " \
    export MYSQL_PWD=root;
    echo 'DROP DATABASE IF EXISTS reference' | mysql -uroot; \
    echo 'CREATE DATABASE reference' | mysql -uroot; \
"

docker-compose run liquibase \
    --username=root \
    --password=root \
    --url=jdbc:mysql://mysql/reference \
    --changeLogFile=/var/www/html/changelog/master.xml \
    update

TS=$(date -u +%Y%m%d-%H%M%S)

docker-compose run liquibase \
    --username=root \
    --password=root \
    --url=jdbc:mysql://mysql/reference?tinyInt1isBit=false \
    --referenceUrl=jdbc:mysql://mysql/ajasta?tinyInt1isBit=false \
    --referenceUsername=root \
    --referencePassword=root \
    --changeLogFile=/var/www/html/changelog/changelog-$TS.xml \
    diffChangeLog


sed -i "
  /<\/databaseChangeLog>/ \
  <include relativeToChangelogFile=\"true\" file=\"/changelog-$TS.xml\"/>" changelog/master.xml

docker exec -it $(docker-compose ps -q application | head -1) chown -R $(id -u):$(id -g) /var/www/html/changelog

docker exec -it $(docker-compose ps -q mysql | head -1) /bin/bash -c " \
    export MYSQL_PWD=root;
    echo 'DROP DATABASE reference' | mysql -uroot; \
"

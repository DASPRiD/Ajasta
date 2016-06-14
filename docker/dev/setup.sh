#!/bin/bash

cp -a docker/dev/docker-compose.override.yml docker-compose.override.yml
cp -a docker/dev/config/* config/autoload/local/
docker-compose up -d
docker/composer.sh install
docker/bower.sh install

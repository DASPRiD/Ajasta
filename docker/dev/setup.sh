#!/bin/bash

# Copy development config files
cp -a docker/dev/docker-compose.override.yml docker-compose.override.yml
cp -a docker/dev/config/* config/autoload/local/

# Install dependencies
docker-compose up -d
docker/composer.sh install
docker/bower.sh install

# Setup database
docker-compose liquibase update

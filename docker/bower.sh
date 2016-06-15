#!/bin/bash

docker-compose up -d application
docker exec -it $(docker-compose ps -q application | head -1) bower --allow-root $@
docker exec -it $(docker-compose ps -q application | head -1) chown -R $(id -u):$(id -g) vendor

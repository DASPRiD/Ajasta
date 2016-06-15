#!/bin/bash

docker-compose up -d application
docker exec -it $(docker-compose ps -q application | head -1) php vendor/bin/doctrine $@

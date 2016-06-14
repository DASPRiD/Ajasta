#!/bin/bash

docker-compose up -d application
docker exec -it $(docker-compose ps -q application | head -1) /bin/bash -c " \
    composer $@; \
    chown -R $(id -u):$(id -g) vendor \
"

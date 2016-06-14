#!/bin/bash

docker-compose up -d application
docker exec -it $(docker-compose ps -q application | head -1) /bin/bash -c " \
    bower --allow-root $@; \
    chown -R $(id -u):$(id -g) public/vendor \
"

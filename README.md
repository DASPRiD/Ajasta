# Ajasta

[![Build Status](https://api.travis-ci.org/DASPRiD/Ajasta.png?branch=master)](http://travis-ci.org/DASPRiD/Ajasta)
[![Coverage Status](https://coveralls.io/repos/DASPRiD/Ajasta/badge.png)](https://coveralls.io/r/DASPRiD/Ajasta)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DASPRiD/Ajasta/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/DASPRiD/Ajasta/?branch=master)

## Introduction

Ajasta is a simple invoicing application built with the latest technologies on the market. It comes with a simple client
and project management, allows you to quickly create new invoices and send them to you clients as PDFs. A templating
system allows you to have your invoices look exactly the way you want them to.

The project is currently under a complete
rewrite, but will mature quickly.

## Installation

While you can run Ajasta completely on your local machine, with your own webserver and such, a
[Docker](https://www.docker.com/) configuration is provided to ease installation. To get started, execute the following
commands:

```bash
$ bower install
```

Then copy the `config/autoload/local/local.php.dist` to `config/autoload/local/local.php` and adjust the database
connection values accordingly. For the Docker image, the connection string will be `mysql://dev:dev@mysql/ajasta`. Then
copy the `docker-compose.override.yml.dist` file to `docker-compose.override.yml`. If port 80 is already used by a local
web server, you may want to change the nginx port to something like `8080:80` (8080 being the host port and 80 being the
internal container port). After that, you can start the Docker containers:

```bash
$ docker-compose up -d
$ docker exec -i $(docker-compose ps -q application | head -1) composer install
```

To set up the database structure, you'll need to run `doctrine-migrations` within the PHP container. To do so, you need
to get the container ID of it. Do so by running `docker ps` and search for the `ajasta_php` image. Then run the
following command:

```bash
$ docker exec -i $(docker-compose ps -q application | head -1) vendor/bin/doctrine-migrations migrations:migrate
```

Finally, you need to create an initial user. To ease this task and not having to fiddle with the database, Ajasta
provides a simple command line tool for this.

```bash
$ docker exec -it $(docker-compose ps -q application | head -1) php bin/create-user.php
```

Now that you've got everything up and running, you can access Ajasta with your browser by opening
<http://localhost:8080>.

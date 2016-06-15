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
[Docker](https://www.docker.com/) configuration is provided to ease installation.

### Development

For a quick installation, run the development setup script:

```bash
$ docker/dev/setup.sh
```

After that, the containers will be running and you can access the application via <http://localhost:8080>. If you want
to install new bower or composer components, there are two helper scripts which will run the executables within the
application container:

```bash
$ docker/composer.sh
$ docker/bower.sh
```

If you made changes to the XML entity schema, you need to generate a matching changelog file. To do so, do the following
steps:

```bash
$ docker/doctrine orm:schema-tool:update --force
$ docker/dev/create-changelog-diff.sh
```

A new changelog file will be generated in the `changelog` folder. Please validate that the generated changes are valid
before committing them.

### Production

Copy the `docker-compose.override.yml.dist` file to `docker-compose.override.yml` and choose the port to use for nginx
as well as the database credentials. After that copy the `config/autoload/local/local.php.dist` to
`config/autoload/local/local.php` and adjust the database connection values accordingly. Then you can start the docker
container:

```bash
$ docker-compose up -d
```

Finally, setup or migrate your database:

```bash
$ docker-compose liquibase update
```
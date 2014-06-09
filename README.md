Ajasta
======

[![Build Status](https://api.travis-ci.org/DASPRiD/Ajasta.png?branch=master)](http://travis-ci.org/DASPRiD/Ajasta)

Introduction
------------
Ajasta is a simple invoicing application built with the latest technologies on
the market. It comes with a simple client and project management, allows you to
quickly create new invoices and send them to you clients as PDFs. A templating
system allows you to have your invoices look exactly the way you want them to.

Installation
------------
The basic installations requires two tools to run, namely:
 - composer (https://getcomposer.org/)
 - Liquibase (http://www.liquibase.org/)

After you have installed those tools, execute the following steps:
 - Create a database
 - Copy ```local.php.dist``` to ```local.php``` in the ```/config/autoload```
   directory and fill out all values
 - Run ```composer install```
 - Run ```liquibase update``` on ```db/db.changelog-master.xml```
 - Point a virtual host to the ```/public``` directory
 - Profit! (seriously, start writing invoices)

Contributing
------------
If you want to contribute to the project, the above steps are usually enough, as
long as you don't want to change the CSS or JavaScript. If you want to do the
latter, you need to install Bower, NPM and grunt-cli. After that, run the
following commands:

 - ```bower install```
 - ```npm install```

This will get you ready to work on the assets (which are located in the assets
folder). As long as you are working on those, just keep the following command
running, which will automatically compile CSS and JavaScript when it changes:

```
grunt
```

If you update bower components to new versions, don't forget to run (and maybe
update) the copy task:

```
grunt copy
```

Work in Progres
---------------
This application is currently work in progress, and just here to demonstrate
what's already implemented. Here's a (likely incomplete) list of what's still
left to do:

- Contacts
- Invoices
- Users (lowest priority, keep it protected with htpasswd for now)
- PDF templates

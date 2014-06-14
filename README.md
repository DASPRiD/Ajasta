Ajasta
======

[![Build Status](https://api.travis-ci.org/DASPRiD/Ajasta.png?branch=master)](http://travis-ci.org/DASPRiD/Ajasta)
[![Coverage Status](https://coveralls.io/repos/DASPRiD/Ajasta/badge.png)](https://coveralls.io/r/DASPRiD/Ajasta)

Introduction
------------
Ajasta is a simple invoicing application built with the latest technologies on
the market. It comes with a simple client and project management, allows you to
quickly create new invoices and send them to you clients as PDFs. A templating
system allows you to have your invoices look exactly the way you want them to.

Installation
------------
The basic installations requires the following primary tools:
 - npm (https://www.npmjs.org)
 - composer (https://getcomposer.org)
 - Liquibase (http://www.liquibase.org)

Additionally, the following global npm packages are required:
 - ```npm install -g grunt-cli```
 - ```npm install -g bower```

Next you need to run npm, bower and composer to install all required packages:
 - ```npm install```
 - ```bower install```
 - ```composer install```

Now that you've got all packages in place, you need to compile the assets:
 - ```grunt compile```

Those were all the prerequisites. Everything left is setting up the database:
 - Create a new database
 - Copy ```local.php.dist``` to ```local.php``` in the ```/config/autoload```
   directory and fill out all values
 - Run Liquibase (in this example with the MySQL driver):
```sh
liquibase --driver=com.mysql.jdbc.Driver \
          --url="jdbc:mysql://localhost/DATABASE" \
          --username=USERNAME \
          --password=PASSWORD \
          --changeLogFile=db/db.changelog-master.xml \
          update
```

That's pretty much all. Now just set up a virtual host and point it to the
```/public``` directory. And for the obligatory last step:

 - Profit! (seriously, start writing invoices)

Contributing
------------
If you want to contribute to the project, the above steps are usually enough. If
you want to work on the JavaScript or stylesheets, there is a helpful grunt task
which will watch for changes and automatically compiles:

```grunt watch``` (this is the default task, you can also just run ```grunt```)

Work in Progres
---------------
This application is currently work in progress, and just here to demonstrate
what's already implemented. Here's a (likely incomplete) list of what's still
left to do:

- Contacts
- Invoices
- Users (lowest priority, keep it protected with htpasswd for now)
- PDF templates

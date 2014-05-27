Ajasta
======

Introduction
------------
Ajasta is a simple invoicing application built with the latest technologies on
the market. It comes with a simple client and project management, allows you to
quickly create new invoices and send them to you clients as PDFs. A templating
system allows you to have your invoices look exactly the way you want them to.

Installation
------------
The installation is currently based on the doctrine-module schema tool, this
should be changed to doctrine migrations at a later point.

- Create a database
- Copy "local.php.dist" to "local.php" in the "/config/autoload" directory and
  fill out all values
- Run "composer install"
- Run "vendor/bin/doctrine-module orm:schema-tool:update --force"
- Point a virtual host to the "/public" directory
- Profit!

Work in Progres
---------------
This application is currently work in progress, and just here to demonstrate
what's already implemented. Here's a (likely incomplete) list of what's still
left to do:

- Projects
- Contacts
- Invoices
- Users (lowest priority, keep it protected with htpasswd for now)
- PDF templates

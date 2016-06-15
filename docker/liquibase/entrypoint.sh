#!/bin/bash

cat > liquibase.properties <<-EOF
	driver: com.mysql.jdbc.Driver
	classpath: /usr/share/java/mysql-connector-java.jar
	url: jdbc:mysql://$MYSQL_ADDRESS/$MYSQL_DATABASE
	username: $MYSQL_USERNAME
	password: $MYSQL_PASSWORD
EOF

exec liquibase $@

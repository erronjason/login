#!/bin/bash

apt-get update
#apt-get -y upgrade
apt-get -y install pwgen

ROOT_PASSWORD="$(pwgen -sc 16 1)"
DB_PASSWORD="$(pwgen -sc 16 1)"

{
  echo "<?php";
  echo "\$dsn = \"mysql:host=localhost;dbname=brave\";";
  echo "\$db_username = \"brave\";";
  echo "\$db_password = \"$DB_PASSWORD\";";
  echo "?>";
} > /vagrant/app/settings.php
echo "db root password: \"$ROOT_PASSWORD\"" > /vagrant/scripts/credentials.txt

echo mysql-server-5.5 mysql-server/root_password password "$ROOT_PASSWORD" | debconf-set-selections
echo mysql-server-5.5 mysql-server/root_password_again password "$ROOT_PASSWORD" | debconf-set-selections
apt-get -y install apache2 php5 mysql-server libapache2-mod-auth-mysql php5-mysql
rm /var/www/html/index.html # Remove the default index apache places in this directory
echo "ServerName localhost" >> /etc/apache2/apache2.conf
/etc/init.d/apache2 restart


if [ ! -f /var/log/databasesetup ];
then
  echo "CREATE USER 'brave'@'localhost' IDENTIFIED BY 'brave'" | mysql -uroot -p"$ROOT_PASSWORD"
  echo "CREATE DATABASE brave" | mysql -uroot -p"$ROOT_PASSWORD"
  echo "GRANT ALL ON brave.* TO 'brave'@'localhost'" | mysql -uroot -p$ROOT_PASSWORD
  echo "flush privileges" | mysql -uroot -p"$ROOT_PASSWORD"
  echo "SET PASSWORD FOR 'brave'@'localhost' = PASSWORD('$DB_PASSWORD')" | mysql -uroot -p$ROOT_PASSWORD
  mysql -uroot -p"$ROOT_PASSWORD" brave < /vagrant/scripts/createdb.sql | mysql -uroot -p$ROOT_PASSWORD
  touch /var/log/databasesetup

  # For now, I'm unsetting the root password for ease of testing
  ##### REMOVE THIS BEFORE FINAL ROLLOUT #####
  mysqladmin -u root -p"$ROOT_PASSWORD" password ''
  ##### REMOVE THIS BEFORE FINAL ROLLOUT #####
fi

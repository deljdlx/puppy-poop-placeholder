# The Puppy Poop Placeholder

## Introduction

### Demo
http://ppp.jlb.ninja/


## Installation

### ImageMagick
```sh
sudo apt-get install -y imagemagick
```

### Wordpress
Install wordpress

#### (lazy mode) You can use this script
Don't forget to change copnfigration variables
```php
#======================================================================
#CONFIGURATION

MYSQL_USER="USER"
MYSQL_PASSWORD="PASSWORD"
MYSQL_HOST="HOST"
WORDPRESS_BDD="DATABASE"
#======================================================================


#téléchargement de wordpress
wget https://wordpress.org/latest.tar.gz

#!rm -rf wordpress

#décompression de l'archive
tar -xzvf latest.tar.gz

#on se place dans le dossier wordpress
cd wordpress

#on met les bons droits
sudo chgrp -R www-data .
find . -type d -exec chmod 755 {} +
find . -type f -exec chmod 644 {} +

#création de la bdd
#mysql -h$MYSQL_HOST -u$MYSQL_USER -p$MYSQL_PASSWORD --execute="CREATE DATABASE $WORDPRESS_BDD CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

#création du fichier de config
cp wp-config-sample.php wp-config.php

#configuration
php -r "file_put_contents('wp-config.php', str_replace('database_name_here', '$WORDPRESS_BDD', file_get_contents('wp-config.php')));";
php -r "file_put_contents('wp-config.php', str_replace('username_here', '$MYSQL_USER', file_get_contents('wp-config.php')));";
php -r "file_put_contents('wp-config.php', str_replace('password_here', '$MYSQL_PASSWORD', file_get_contents('wp-config.php')));";
php -r "file_put_contents('wp-config.php', str_replace('define( \'WP_DEBUG\', false )', 'define( \'WP_DEBUG\', true )', file_get_contents('wp-config.php')));";
php -r "file_put_contents('wp-config.php', str_replace('put your unique phrase here', uniqid('salt-', true), file_get_contents('wp-config.php')));";
php -r "file_put_contents('wp-config.php', 'define( \'FS_METHOD\', \'direct\');', FILE_APPEND);";

```
# Usage

# Todo
#!/bin/bash
a2enmod rewrite >> /dev/null
docker-php-ext-install mysqli pdo pdo_mysql >> /dev/null
service apache2 restart >> /dev/null
echo "Apache e interprete PHP listo y ejecutando..."
tail -f /dev/null
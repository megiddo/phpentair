#!/bin/sh

/usr/sbin/service nginx start
/usr/sbin/service php8.1-fpm start
/usr/sbin/service cron start

/usr/bin/php /var/www/pentair/signal/listen.php
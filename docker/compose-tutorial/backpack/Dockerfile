FROM lagdo/alpine-php-nginx-unit

ARG PHP_USER
ARG PHP_UID
ARG PHP_GID
ENV PHP_USER=${PHP_USER}
ENV PHP_UID=${PHP_UID}
ENV PHP_GID=${PHP_GID}

RUN set -xe && \
  apk add --no-cache bash pcre curl wget zip vim git sqlite && \
  install-php-extensions pdo pdo_sqlite sqlite3 pdo_mysql mysqlnd mysqli pdo_pgsql pgsql xdebug

# Configure Nginx Unit
COPY backpack/unit/config.json /docker-entrypoint.d/config.json

RUN addgroup -g ${PHP_GID} --system ${PHP_USER} && \
  adduser -G ${PHP_USER} --system -D -s /bin/sh -u ${PHP_UID} ${PHP_USER} && \
  touch /var/run/unit.pid && \
  touch /var/log/unit.log && \
  mkdir -p /usr/local/var && \
  mkdir -p /var/cache/jaxon && \
  chown -R ${PHP_USER}:${PHP_USER} /var/log/unit.log /usr/local/var /var/www \
    /var/run /run /var/cache/jaxon

USER ${PHP_USER}

WORKDIR /var/www

# Install Laravel 12 and Backpack 7
RUN composer create-project laravel/laravel backpack 12.x && \
  (cd backpack && \
    mkdir public/jaxon && \
    mkdir -p app/Http/Middleware && \
    php artisan key:generate --ansi && \
    php artisan storage:link && \
    composer update psr/log:^3.0 && \
    composer require jaxon-php/jaxon-laravel jaxon-php/jaxon-dialogs jaxon-php/jaxon-upload && \
    # composer require lagdo/jaxon-dbadmin lagdo/dbadmin-driver-mysql lagdo/dbadmin-driver-pgsql && \
    # composer require lagdo/dbadmin-driver-sqlite lagdo/ui-builder-bootstrap5 && \
    composer require backpack/crud:"^7.0" && \
    composer require infisical/php-sdk:^0.0.1)

EXPOSE 8080

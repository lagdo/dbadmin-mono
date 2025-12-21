FROM lagdo/alpine-php-nginx-unit

ARG PHP_USER
ARG PHP_UID
ARG PHP_GID
ENV PHP_USER=${PHP_USER}
ENV PHP_UID=${PHP_UID}
ENV PHP_GID=${PHP_GID}

RUN set -xe && \
  apk add --no-cache bash pcre curl wget zip vim git mysql-client postgresql-client sqlite \
  # This is useful for the mysql client to be able to connect to the mysql server
    mariadb-connector-c && \ 
  install-php-extensions pdo pdo_sqlite sqlite3 pdo_mysql mysqlnd mysqli pdo_pgsql pgsql xdebug

# Configure Nginx Unit
COPY demo/config/unit.json /docker-entrypoint.d/config.json

RUN addgroup -g ${PHP_GID} --system ${PHP_USER} && \
  adduser -G ${PHP_USER} --system -D -s /bin/sh -u ${PHP_UID} ${PHP_USER} && \
  mkdir -p /var/cache/jaxon && \
  chown -R ${PHP_USER}:${PHP_USER} /var/www /var/run /run /var/cache/jaxon

WORKDIR /var/www
EXPOSE 8080

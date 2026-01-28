FROM lagdo/alpine-php-nginx-unit

ARG PHP_USER
ARG PHP_UID
ARG PHP_GID
ENV PHP_USER=${PHP_USER}
ENV PHP_UID=${PHP_UID}
ENV PHP_GID=${PHP_GID}

RUN install-php-extensions pdo pdo_sqlite sqlite3 pdo_mysql mysqlnd mysqli pdo_pgsql pgsql xdebug

# Configure Nginx Unit
COPY dev/config/unit.json /docker-entrypoint.d/config.json

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
EXPOSE 8080

ARG DBADMIN_VERSION=0.9.0

# Root builder
FROM lagdo/alpine-php-free-unit

ARG DBADMIN_VERSION
ARG PHP_USER
ARG PHP_UID
ARG PHP_GID
ARG PHP_FRW
ENV PHP_USER=${PHP_USER}
ENV PHP_UID=${PHP_UID}
ENV PHP_GID=${PHP_GID}
ENV PHP_FRW=${PHP_FRW}

RUN set -xe && \
  apk add --no-cache openssl ca-certificates && \
  install-php-extensions pdo pdo_sqlite sqlite3 pdo_mysql mysqlnd mysqli pdo_pgsql pgsql

# Install the root CA certificate
COPY --from=secrets-ssl dbadmin_root_ca.pem /usr/local/share/ca-certificates/dbadmin_root_ca.crt
RUN update-ca-certificates

# Configure Free Unit
COPY unit/${PHP_FRW}/config.json /docker-entrypoint.d/config.json

# App root
COPY . /var/www

RUN addgroup -g ${PHP_GID} --system ${PHP_USER} && \
  adduser -G ${PHP_USER} --system -D -s /bin/sh -u ${PHP_UID} ${PHP_USER} && \
  touch /var/run/unit.pid && \
  touch /var/log/unit.log && \
  mkdir -p /usr/local/var && \
  mkdir -p /var/cache/jaxon && \
  chown -R ${PHP_USER}:${PHP_USER} /var/log/unit.log \
    /usr/local/var /var/www /var/run /run /var/cache/jaxon

USER ${PHP_USER}

# Install Composer packages
# RUN cd /var/www && \
#   composer install --no-dev && \
#   cp .env.docker .env && \
#   composer run post-create-project-cmd

WORKDIR /var/www
EXPOSE 8080

LABEL maintainer="Thierry Feuzeu <thierry.feuzeu@gmail.com>" \
  org.opencontainers.image.source="https://github.com/lagdo/dbadmin-app-${PHP_FRW}" \
  org.opencontainers.image.description="Jaxon DbAdmin: a web-based database management tool." \
  org.opencontainers.image.licenses="BSD 3-Clause" \
  org.opencontainers.image.version="${DBADMIN_VERSION}"

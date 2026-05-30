FROM lagdo/alpine-php-nginx-unit

ARG PHP_USER
ARG PHP_UID
ARG PHP_GID
ENV PHP_USER=${PHP_USER}
ENV PHP_UID=${PHP_UID}
ENV PHP_GID=${PHP_GID}

RUN set -xe && \
  apk add --no-cache bash pcre curl wget zip vim git sqlite \
    aws-cli nodejs-current npm jq gawk python3 ca-certificates && \
  install-php-extensions sqlite3 mysqlnd mysqli pgsql pdo pdo_sqlite pdo_mysql pdo_pgsql xdebug

# Install the root CA certificate
COPY ssl/rootCA.pem /usr/local/share/ca-certificates/rootCA.crt
RUN update-ca-certificates

# Configure Nginx Unit
COPY dbadmin/unit/config.json /docker-entrypoint.d/config.json

RUN addgroup -g ${PHP_GID} --system ${PHP_USER} && \
  adduser -G ${PHP_USER} --system -D -s /bin/sh -u ${PHP_UID} ${PHP_USER} && \
  touch /var/run/unit.pid && \
  touch /var/log/unit.log && \
  mkdir -p /usr/local/var && \
  mkdir -p /var/cache/jaxon && \
  chown -R ${PHP_USER}:${PHP_USER} /var/log/unit.log /usr/local/var /var/www \
    /var/run /run /var/cache/jaxon

# Install the Google Cloud CLI.
# See https://gist.github.com/oofnikj/7a2fb1e6b20b397775d882ecd8980159.
ARG TARGETARCH
ARG TARGETOS
RUN if [ "$TARGETARCH" = "amd64" ] ; then \
    GCLOUD_ARCH="${TARGETOS}-x86_64"; \
    elif [ "$TARGETARCH" = "arm64" ] ; then \
    GCLOUD_ARCH="${TARGETOS}-arm"; \
    fi; \
    export GCLOUD_ARCH; \
    env | grep GCLOUD_ARCH >> /etc/profile.d/gcloud-arch.env
RUN . /etc/profile.d/gcloud-arch.env
RUN curl -sL "https://www.googleapis.com/storage/v1/b/cloud-sdk-release/o?prefix=google-cloud-sdk-5" \
    | jq -r ".items[].selfLink | select ( match (\"${GCLOUD_ARCH}\") )" \
    | grep '.tar.gz' | tail -n1 \
    | curl -sL $(awk '{print $1"?alt=media"}') | tar xzf - -C /usr/local/lib && \
  /usr/local/lib/google-cloud-sdk/install.sh --quiet && \
  echo "export PATH=/usr/local/lib/google-cloud-sdk/bin:$PATH" | tee -a /etc/profile.d/gcloud-sdk.sh

USER ${PHP_USER}

WORKDIR /var/www
EXPOSE 8080

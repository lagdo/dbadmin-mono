ARG IMAGE_TAG

FROM lagdo/jaxon-dbadmin:${IMAGE_TAG}

# Uncomment all the following if a root CA certificate needs to be installed.
ARG PHP_USER

USER root
RUN set -xe && apk add --no-cache openssl ca-certificates

COPY --from=secrets-ssl dbadmin_root_ca.pem /usr/local/share/ca-certificates/dbadmin_root_ca.crt
RUN update-ca-certificates && install-php-extensions

USER ${PHP_USER}

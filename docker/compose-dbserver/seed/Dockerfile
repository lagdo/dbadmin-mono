FROM alpine:3.23

ARG SEED_USER
ARG SEED_UID
ARG SEED_GID
ENV SEED_USER=${SEED_USER}
ENV SEED_UID=${SEED_UID}
ENV SEED_GID=${SEED_GID}

RUN set -xe && \
  apk add --no-cache bash curl pcre wget mysql-client postgresql-client \
  # This is useful for the mysql client to be able to connect to the mysql server
    mariadb-connector-c

RUN addgroup -g ${SEED_GID} --system ${SEED_USER} && \
  adduser -G ${SEED_USER} --system -D -s /bin/sh -u ${SEED_UID} ${SEED_USER}

USER ${SEED_USER}
WORKDIR /home/${SEED_USER}

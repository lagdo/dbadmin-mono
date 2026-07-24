FROM alpine:3.23 AS dbadmin-cli-base

ARG CLI_USER
ARG CLI_UID
ARG CLI_GID
ENV CLI_USER=${CLI_USER}
ENV CLI_UID=${CLI_UID}
ENV CLI_GID=${CLI_GID}

RUN set -xe && \
  apk add --no-cache bash curl pcre wget mysql-client postgresql-client \
  # This is useful for the mysql client to be able to connect to the mysql server
    mariadb-connector-c

RUN addgroup -g ${CLI_GID} --system ${CLI_USER} && \
  adduser -G ${CLI_USER} --system -D -s /bin/sh -u ${CLI_UID} ${CLI_USER}

FROM dbadmin-cli-base AS dbadmin-cli-no-secret

USER ${CLI_USER}
WORKDIR /home/${CLI_USER}

FROM dbadmin-cli-base AS dbadmin-cli-secrets

RUN set -xe && \
  curl -sL "https://artifacts-cli.infisical.com/setup.apk.sh" -o "setup.apk.sh" && \
  sh setup.apk.sh && \
  apk add --no-cache openssl ca-certificates jq gawk python3 aws-cli infisical

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
    | grep '.tar.gz' \
    | tail -n1 \
    | curl -sL $(awk '{print $1"?alt=media"}') \
    | tar xzf - -C /usr/local/lib && \
  /usr/local/lib/google-cloud-sdk/install.sh --quiet && \
  echo "export PATH=/usr/local/lib/google-cloud-sdk/bin:$PATH" \
    | tee -a /etc/profile.d/gcloud-sdk.sh

# Install the root CA certificate
COPY --from=secrets-ssl dbadmin_root_ca.pem /usr/local/share/ca-certificates/dbadmin_root_ca.crt
RUN update-ca-certificates

USER ${CLI_USER}
WORKDIR /home/${CLI_USER}

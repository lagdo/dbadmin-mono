#!/bin/sh
set -e

# Install Composer packages
/usr/local/bin/nginx-create-certs.sh

exec "$@"

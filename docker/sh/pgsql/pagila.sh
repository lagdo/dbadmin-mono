#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
SAKILA_REPO=https://raw.githubusercontent.com/devrimgunduz/pagila/refs/heads/master
SCHEMA_SCRIPT=pagila-schema.sql
DATA_SCRIPT=pagila-insert-data.sql
DB_SERVER_NAME=db-postgresql

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ./${SCHEMA_SCRIPT} ] || wget -O ./${SCHEMA_SCRIPT} ${SAKILA_REPO}/${SCHEMA_SCRIPT}
[ -f ./${DATA_SCRIPT} ] || wget -O ./${DATA_SCRIPT} ${SAKILA_REPO}/${DATA_SCRIPT}

PGPASSWORD=dbadmin createdb -h ${DB_SERVER_NAME} -U postgres pagila
PGPASSWORD=dbadmin psql -h ${DB_SERVER_NAME} -U postgres -d pagila -f ./${SCHEMA_SCRIPT}
PGPASSWORD=dbadmin psql -h ${DB_SERVER_NAME} -U postgres -d pagila -f ./${DATA_SCRIPT}

cd -

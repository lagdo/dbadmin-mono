#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
SAKILA_REPO=https://raw.githubusercontent.com/jOOQ/sakila/refs/heads/main/postgres-sakila-db
SCHEMA_SCRIPT=postgres-sakila-schema.sql
DATA_SCRIPT=postgres-sakila-insert-data.sql
DB_SERVER_NAME=db-postgresql

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ./${SCHEMA_SCRIPT} ] || wget -O ./${SCHEMA_SCRIPT} ${SAKILA_REPO}/${SCHEMA_SCRIPT}
[ -f ./${DATA_SCRIPT} ] || wget -O ./${DATA_SCRIPT} ${SAKILA_REPO}/${DATA_SCRIPT}

PGPASSWORD=dbadmin createdb -h ${DB_SERVER_NAME} -U postgres sakila
PGPASSWORD=dbadmin psql -h ${DB_SERVER_NAME} -U postgres -d sakila -f ./${SCHEMA_SCRIPT}
PGPASSWORD=dbadmin psql -h ${DB_SERVER_NAME} -U postgres -d sakila -f ./${DATA_SCRIPT}

cd -

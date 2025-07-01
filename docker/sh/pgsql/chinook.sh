#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
CHINOOK_REPO=https://github.com/neondatabase-labs/postgres-sample-dbs/raw/refs/heads/main
CHINOOK_SCRIPT=chinook.sql
DB_SERVER_NAME=db-postgresql

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ./${CHINOOK_SCRIPT} ] || wget -O ./${CHINOOK_SCRIPT} ${CHINOOK_REPO}/${CHINOOK_SCRIPT}

PGPASSWORD=dbadmin createdb -h ${DB_SERVER_NAME} -U postgres chinook
PGPASSWORD=dbadmin psql -h ${DB_SERVER_NAME} -U postgres -d chinook -f ./${CHINOOK_SCRIPT}

cd -

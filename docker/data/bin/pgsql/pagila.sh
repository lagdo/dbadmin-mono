#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
SAKILA_REPO=https://raw.githubusercontent.com/devrimgunduz/pagila/refs/heads/master
SCHEMA_SCRIPT=pagila-schema.sql
DATA_SCRIPT=pagila-insert-data.sql

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ./${SCHEMA_SCRIPT} ] || wget -O ./${SCHEMA_SCRIPT} ${SAKILA_REPO}/${SCHEMA_SCRIPT}
[ -f ./${DATA_SCRIPT} ] || wget -O ./${DATA_SCRIPT} ${SAKILA_REPO}/${DATA_SCRIPT}

# This script does not crate the database
createdb -h postgresql-14 -U postgres -W pagila
psql -h postgresql-14 -U postgres -W -d pagila -f ./${SCHEMA_SCRIPT}
psql -h postgresql-14 -U postgres -W -d pagila -f ./${DATA_SCRIPT}

cd -

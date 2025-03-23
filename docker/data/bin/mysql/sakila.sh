#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
SAKILA_REPO=https://raw.githubusercontent.com/jOOQ/sakila/refs/heads/main/mysql-sakila-db
SCHEMA_SCRIPT=mysql-sakila-schema.sql
DATA_SCRIPT=mysql-sakila-insert-data.sql

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ${DEST_DIR}/${SCHEMA_SCRIPT} ] || curl ${SAKILA_REPO}/${SCHEMA_SCRIPT} -o ${DEST_DIR}/${SCHEMA_SCRIPT}
[ -f ${DEST_DIR}/${DATA_SCRIPT} ] || curl ${SAKILA_REPO}/${DATA_SCRIPT} -o ${DEST_DIR}/${DATA_SCRIPT}

mysql -h mysql-5 -u root -p < ${DEST_DIR}/${SCHEMA_SCRIPT}
mysql -h mysql-5 -u root -p sakila < ${DEST_DIR}/${DATA_SCRIPT}

cd -

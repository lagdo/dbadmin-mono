#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
SAKILA_REPO=https://raw.githubusercontent.com/jOOQ/sakila/refs/heads/main/mysql-sakila-db
SCHEMA_SCRIPT=mysql-sakila-schema.sql
DATA_SCRIPT=mysql-sakila-insert-data.sql
DB_SERVER_NAME=dbadmin-mariadb

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ./${SCHEMA_SCRIPT} ] || curl ${SAKILA_REPO}/${SCHEMA_SCRIPT} -o ./${SCHEMA_SCRIPT}
[ -f ./${DATA_SCRIPT} ] || curl ${SAKILA_REPO}/${DATA_SCRIPT} -o ./${DATA_SCRIPT}

mariadb -h ${DB_SERVER_NAME} -u root -pdbadmin -e 'drop database if exists sakila;'
mariadb -h ${DB_SERVER_NAME} -u root -pdbadmin -e 'create database sakila;'
mariadb -h ${DB_SERVER_NAME} -u root -pdbadmin < ./${SCHEMA_SCRIPT}
mariadb -h ${DB_SERVER_NAME} -u root -pdbadmin sakila < ./${DATA_SCRIPT}

cd -

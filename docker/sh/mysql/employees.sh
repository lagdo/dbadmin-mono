#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
EMPLOYEES_REPO=https://raw.githubusercontent.com/datacharmer/test_db/refs/heads/master
DB_SERVER_NAME=dbadmin-mariadb

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ./employees.sql ] || curl ${EMPLOYEES_REPO}/employees.sql -o ./employees.sql
[ -f ./show_elapsed.sql ] || curl ${EMPLOYEES_REPO}/show_elapsed.sql -o ./show_elapsed.sql

for DATA in departments employees dept_emp dept_manager titles salaries1 salaries2 salaries3
do
    [ -f ./load_${DATA}.dump ] || curl ${EMPLOYEES_REPO}/load_${DATA}.dump -o ./load_${DATA}.dump
done

mariadb -h ${DB_SERVER_NAME} -u root -pdbadmin < ./employees.sql

cd -

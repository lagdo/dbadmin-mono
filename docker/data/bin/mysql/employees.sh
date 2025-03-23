#!/bin/bash

DEST_DIR=$(dirname "$0")/sql
EMPLOYEES_REPO=https://raw.githubusercontent.com/datacharmer/test_db/refs/heads/master

mkdir -p ${DEST_DIR}
cd ${DEST_DIR}

[ -f ${DEST_DIR}/employees.sql ] || curl ${EMPLOYEES_REPO}/employees.sql -o ${DEST_DIR}/employees.sql
[ -f ${DEST_DIR}/show_elapsed.sql ] || curl ${EMPLOYEES_REPO}/show_elapsed.sql -o ${DEST_DIR}/show_elapsed.sql

for DATA in departments employees dept_emp dept_manager titles salaries1 salaries2 salaries3
do
    [ -f ${DEST_DIR}/load_${DATA}.dump ] || curl ${EMPLOYEES_REPO}/load_${DATA}.dump -o ${DEST_DIR}/load_${DATA}.dump
done

mysql -h mysql-5 -u root -p < ${DEST_DIR}/employees.sql

cd -

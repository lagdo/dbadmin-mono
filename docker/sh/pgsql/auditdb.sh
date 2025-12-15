#!/bin/bash

DB_SERVER_NAME=dbadmin-pgsql-17

MIGRATIONS_DIR=$(cd ../../../jaxon-dbadmin/migrations; pwd)
LOGGING_SCRIPT="${MIGRATIONS_DIR}/pgsql/01-create-command-tables.up.sql"

PGPASSWORD=dbadmin createdb -h ${DB_SERVER_NAME} -U postgres auditdb
PGPASSWORD=dbadmin psql -h ${DB_SERVER_NAME} -U postgres -d auditdb -f ${LOGGING_SCRIPT}

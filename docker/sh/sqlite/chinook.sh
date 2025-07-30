#!/bin/bash

DB_FILE=/var/lib/sqlite/3/chinook.db
CHINOOK_REPO=https://github.com/lerocha/chinook-database/raw/refs/heads/master/ChinookDatabase/DataSources
CHINOOK_FILE=Chinook_Sqlite.sqlite

[ -f ${DB_FILE} ] || wget -O ${DB_FILE} ${CHINOOK_REPO}/${CHINOOK_FILE}

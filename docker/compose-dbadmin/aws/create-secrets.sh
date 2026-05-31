#/bin/bash

# Create secrets for the dev env databases.
ENDPOINT_URL=http://ministack.local:7201
PROFILE=dbadmin

function create_secret()
{
    SECRET_NAME=$1
    SECRET_JSON=$2

    aws --endpoint-url=${ENDPOINT_URL} --profile ${PROFILE} secretsmanager \
        create-secret --name ${SECRET_NAME} --secret-string '${SECRET_JSON}'
}

create_secret users.queries.database '{"username":"postgres", "password":"dbadmin"}'

create_secret users.servers.dbadmin-pgsql-17 '{"username":"postgres", "password":"dbadmin"}'

create_secret users.servers.dbadmin-pgsql-14 '{"username":"postgres", "password":"dbadmin"}'

create_secret users.servers.dbadmin-mariadb '{"username":"root", "password":"dbadmin"}'

create_secret users.servers.dbadmin-mysql '{"username":"root", "password":"dbadmin"}'

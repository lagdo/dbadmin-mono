#/bin/bash

# Create secrets for the dev env databases.
ENDPOINT_URL=http://ministack.local:4566

aws --endpoint-url=${ENDPOINT_URL} --profile dbadmin secretsmanager create-secret \
    --name users.queries.database \
    --secret-string '{"username":"postgres", "password":"dbadmin"}'

aws --endpoint-url=${ENDPOINT_URL} --profile dbadmin secretsmanager create-secret \
    --name users.servers.dbadmin-pgsql-17 \
    --secret-string '{"username":"postgres", "password":"dbadmin"}'

aws --endpoint-url=${ENDPOINT_URL} --profile dbadmin secretsmanager create-secret \
    --name users.servers.dbadmin-pgsql-14 \
    --secret-string '{"username":"postgres", "password":"dbadmin"}'

aws --endpoint-url=${ENDPOINT_URL} --profile dbadmin secretsmanager create-secret \
    --name users.servers.dbadmin-mariadb \
    --secret-string '{"username":"root", "password":"dbadmin"}'

aws --endpoint-url=${ENDPOINT_URL} --profile dbadmin secretsmanager create-secret \
    --name users.servers.dbadmin-mysql \
    --secret-string '{"username":"root", "password":"dbadmin"}'

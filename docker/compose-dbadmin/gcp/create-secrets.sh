#/bin/bash

# Create secrets for the dev env databases.
PROJECTS_PATH=http://gcp.secrets.local:7204/v1/projects
PROJECT_ID=dbadmin

function create_secret()
{
    SECRET_KEY=$1
    SECRET_VALUE=$2

    # Create the secret.
    curl -X POST "${PROJECTS_PATH}/${PROJECT_ID}/secrets?secretId=${SECRET_KEY}" \
        -H "Content-Type: application/json" \
        -d '{"replication":{"automatic":{}}}'
    # Add a value to it.
    curl -X POST "${PROJECTS_PATH}/${PROJECT_ID}/secrets/${SECRET_KEY}:addVersion" \
        -H "Content-Type: application/json" \
        -d '{"payload":{"data":"'$(echo -n ${SECRET_VALUE} | base64)'"}}'
}

create_secret db.users.queries.database.username postgres
create_secret db.users.queries.database.password dbadmin

create_secret db.users.servers.dbadmin-pgsql-17.username postgres
create_secret db.users.servers.dbadmin-pgsql-17.password dbadmin

create_secret db.users.servers.dbadmin-pgsql-14.username postgres
create_secret db.users.servers.dbadmin-pgsql-14.password dbadmin

create_secret db.users.servers.dbadmin-mariadb.username root
create_secret db.users.servers.dbadmin-mariadb.password dbadmin

create_secret db.users.servers.dbadmin-mysql.username root
create_secret db.users.servers.dbadmin-mysql.password dbadmin

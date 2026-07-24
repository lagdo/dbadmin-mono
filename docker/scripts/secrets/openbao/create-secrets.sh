#/bin/bash

# Create secrets for the dev env databases.
TOKEN=dbadmin
NAMESPACE=dbadmin
PROJECT_ID=dbadmin
SECRET_PATH=https://bao.secrets.loc/v1/${PROJECT_ID}/data

function create_secret()
{
    SECRET_KEY=$1
    SECRET_VALUE=$2

    # Create the secret.
    curl -H "X-Vault-Token: ${TOKEN}" \
        -H "Content-Type: application/json" \
        -X POST \
        -d '{"data":{"value":"'${SECRET_VALUE}'"}}' \
        ${SECRET_PATH}/${SECRET_KEY}
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

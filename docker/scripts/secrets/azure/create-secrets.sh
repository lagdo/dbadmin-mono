#/bin/bash

# Create secrets for the dev env databases.
# The vault name is included in the URL
ENDPOINT_URL=https://floci-azr.secrets.loc/devstoreaccount2-keyvault

function create_secret()
{
    SECRET_NAME=$1
    SECRET_VALUE=$2

    # Without the Authorization header, the curl command silently fails.
    curl -X PUT \
        -H "Authorization: Bearer token" \
        -H "Content-Type: application/json" \
        -d '{"value":"'${SECRET_VALUE}'"}' \
        "${ENDPOINT_URL}/secrets/${SECRET_NAME}?api-version=7.0"
    # New line in the console output.
    echo ''
}

create_secret db-users-queries-database-username postgres
create_secret db-users-queries-database-password dbadmin

create_secret db-users-servers-dbadmin-pgsql-17-username postgres
create_secret db-users-servers-dbadmin-pgsql-17-password dbadmin

create_secret db-users-servers-dbadmin-pgsql-14-username postgres
create_secret db-users-servers-dbadmin-pgsql-14-password dbadmin

create_secret db-users-servers-dbadmin-mariadb-username root
create_secret db-users-servers-dbadmin-mariadb-password dbadmin

create_secret db-users-servers-dbadmin-mysql-username root
create_secret db-users-servers-dbadmin-mysql-password dbadmin

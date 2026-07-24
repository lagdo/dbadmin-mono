#/bin/bash

# Create secrets for the dev env databases.
DOMAIN=https://inf.secrets.loc
PROJECT_ID=6cf10c24-a165-4379-9a23-ae3918d1abaa
MACHINE_CLIENT_ID=d209de07-1505-4a1d-91b4-66e0625f2411
MACHINE_CLIENT_SECRET=96d4c7179f2bccbd379f5d64bec0047c5a1909eb6b9c11e65b5f0b5e98fab73d

function create_secret()
{
    SECRET_KEY=$1
    SECRET_VALUE=$2

    # Create the secret.
    infisical secrets set ${SECRET_KEY}=${SECRET_VALUE}
}


# Login with the domain
infisical login --method=universal-auth \
    --domain=${DOMAIN} \
    --client-id=${MACHINE_CLIENT_ID} \
    --client-secret=${MACHINE_CLIENT_SECRET} \
    --silent --plain
# All other commands will also use the same domain automatically
infisical secrets --projectId ${PROJECT_ID} --env dev

create_secret users.queries.database.username postgres
create_secret users.queries.database.password dbadmin

create_secret users.servers.dbadmin-pgsql-17.username postgres
create_secret users.servers.dbadmin-pgsql-17.password dbadmin

create_secret users.servers.dbadmin-pgsql-14.username postgres
create_secret users.servers.dbadmin-pgsql-14.password dbadmin

create_secret users.servers.dbadmin-mariadb.username root
create_secret users.servers.dbadmin-mariadb.password dbadmin

create_secret users.servers.dbadmin-mysql.username root
create_secret users.servers.dbadmin-mysql.password dbadmin

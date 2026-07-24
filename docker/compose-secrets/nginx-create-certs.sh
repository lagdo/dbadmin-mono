#!/usr/bin/env sh

# See https://gist.github.com/dmadisetti/16006751fd6e1526fa9c2f2e1660e8e3

SSL_DIR=/data/ssl
ROOT_CA=/data/ssl/dbadmin_root_ca.pem

function create_root_ca()
{
    # Do not overwrite the existing certificate
    [ -f ${ROOT_CA} ] && return

    # Create the root CA
    mkcert --install

    # Also renew the server certificates
    rm ${SSL_DIR}/${DOMAIN}.key ${SSL_DIR}/${DOMAIN}.crt || true

    # Copy the root CA to a shared dir
    CRT_DIR=`mkcert --CAROOT`
    cp ${CRT_DIR}/rootCA.pem ${ROOT_CA}
}

function create_certificates()
{
    DOMAIN=$1

    # Do not overwrite the existing certificate
    [ -f ${SSL_DIR}/${DOMAIN}.key ] && return
    [ -f ${SSL_DIR}/${DOMAIN}.crt ] && return

    mkdir -p ${SSL_DIR}
    mkcert -key-file ${SSL_DIR}/${DOMAIN}.key \
        -cert-file ${SSL_DIR}/${DOMAIN}.crt \
        '*'.${DOMAIN} localhost
}

create_root_ca
create_certificates "secrets.loc"

#/bin/bash

REPO=lagdo/jaxon-dbadmin
PROJECT_ROOT=$1
DBADMIN_VERSION=0.11.1
VERSION_MINOR=${DBADMIN_VERSION:0:4}

function build_app()
{
    PROJECT_DIR=..
    FRAMEWORK=$1

    (
        cd ${PROJECT_ROOT}/dbadmin-app-${FRAMEWORK}/docker \
        && docker build --no-cache \
            --build-arg PHP_USER=dbadmin \
            --build-arg PHP_UID=1000 \
            --build-arg PHP_GID=1000 \
            -t ${REPO}:${FRAMEWORK} \
            -f Dockerfile ${PROJECT_DIR} \
        && docker tag ${REPO}:${FRAMEWORK} ${REPO}:${DBADMIN_VERSION}-${FRAMEWORK} \
        && docker push ${REPO}:${DBADMIN_VERSION}-${FRAMEWORK} \
        && docker tag ${REPO}:${FRAMEWORK} ${REPO}:${VERSION_MINOR}-${FRAMEWORK} \
        && docker push ${REPO}:${VERSION_MINOR}-${FRAMEWORK} \
        && docker tag ${REPO}:${FRAMEWORK} ${REPO}:${FRAMEWORK} \
        && docker push ${REPO}:${FRAMEWORK}
    )
}

build_app laravel
build_app symfony
build_app slim

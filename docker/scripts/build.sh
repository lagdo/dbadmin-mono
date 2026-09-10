#/bin/bash

REPO=lagdo/jaxon-dbadmin
PROJECT_ROOT=$1

function build_app()
{
    PROJECT_DIR=..
    FRAMEWORK=$1
    VERSION_FULL=$2
    VERSION_MINOR=${VERSION_FULL:0:4}

    (
        cd ${PROJECT_ROOT}/dbadmin-app-${FRAMEWORK}/docker \
        && docker build --no-cache \
            --build-arg PHP_USER=dbadmin \
            --build-arg PHP_UID=1000 \
            --build-arg PHP_GID=1000 \
            -t ${REPO}:${FRAMEWORK} \
            -f Dockerfile ${PROJECT_DIR} \
        && docker tag ${REPO}:${FRAMEWORK} ${REPO}:${VERSION_FULL}-${FRAMEWORK} \
        && docker push ${REPO}:${VERSION_FULL}-${FRAMEWORK} \
        && docker tag ${REPO}:${FRAMEWORK} ${REPO}:${VERSION_MINOR}-${FRAMEWORK} \
        && docker push ${REPO}:${VERSION_MINOR}-${FRAMEWORK} \
        && docker tag ${REPO}:${FRAMEWORK} ${REPO}:${FRAMEWORK} \
        && docker push ${REPO}:${FRAMEWORK}
    )
}

build_app laravel 0.11.4
build_app symfony 0.11.5
build_app slim 0.11.5

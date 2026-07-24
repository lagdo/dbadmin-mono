# See https://github.com/alpine-docker/multi-arch-docker-images/blob/master/mkcert/Dockerfile
# Step 1: Build mkcert binary for multiple architectures
FROM --platform=$BUILDPLATFORM golang:1.20-alpine AS mkcert-builder

# Install dependencies
RUN apk add --no-cache git bash gcc musl-dev

# Set up working directory
WORKDIR /app

# Clone mkcert repository and checkout the latest tag
RUN git clone https://github.com/FiloSottile/mkcert.git . && \
    latest_tag=$(git describe --tags `git rev-list --tags --max-count=1`) && \
    git checkout $latest_tag

# Build mkcert binary based on target architecture
ARG TARGETPLATFORM
RUN go env -w GOOS=linux && \
    if [ "$TARGETPLATFORM" = "linux/arm64" ]; then \
      go env -w GOARCH=arm64; \
    elif [ "$TARGETPLATFORM" = "linux/amd64" ]; then \
      go env -w GOARCH=amd64; \
    fi && \
    go build -ldflags "-X main.Version=$latest_tag" -o mkcert

FROM alpine:latest

# Copy mkcert binary from mkcert-builder stage
COPY --from=mkcert-builder /app/mkcert /usr/local/bin/mkcert
RUN apk add --no-cache bash

# Copy certs install scripts
COPY ./nginx-create-certs.sh /usr/local/bin/nginx-create-certs.sh
RUN chmod +x /usr/local/bin/nginx-create-certs.sh
CMD ["/usr/local/bin/nginx-create-certs.sh"]

#!/usr/bin/env bash

PROJECT_DIR="$(dirname "$0")/.."

docker-compose build --build-arg UID=$UID
docker-compose up -d

${PROJECT_DIR}/docker.sh composer install
${PROJECT_DIR}/docker.sh bin/reload-db.sh
${PROJECT_DIR}/docker.sh npm install
${PROJECT_DIR}/docker.sh npm run dev

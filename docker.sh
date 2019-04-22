#!/usr/bin/env bash
if [[ -z "$@" ]] ; then
    TO_EXEC='bash';
else
    TO_EXEC=$@;
fi

docker exec -it -u symfony-demo symfony-demo-php ${TO_EXEC}
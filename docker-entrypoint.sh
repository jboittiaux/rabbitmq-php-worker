#!/bin/bash
set -e

# check required ENV vars
if [ -z "$RABBITMQ_HOST" ]; then
    echo >&2 'Error: missing RABBITMQ_HOST environment variable'
    exit 1
fi
if [ -z "$RABBITMQ_PORT" ]; then
    echo >&2 'Error: missing RABBITMQ_PORT environment variable'
    exit 1
fi
if [ -z "$RABBITMQ_USER" ]; then
    echo >&2 'Error: missing RABBITMQ_USER environment variable'
    exit 1
fi
if [ -z "$RABBITMQ_PASS" ]; then
    echo >&2 'Error: missing RABBITMQ_PASS environment variable'
    exit 1
fi

# install application dependencies
if [ -e 'composer.json' ]; then
    composer install -q
fi

exec "$@"

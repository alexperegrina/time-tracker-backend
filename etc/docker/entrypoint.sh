#!/bin/bash

if [ ! -d "vendor" ]; then
  composer install --prefer-dist --no-progress --no-interaction
fi

#make restore-env

exec "$@"
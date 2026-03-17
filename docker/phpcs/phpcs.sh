#!/bin/bash

docker run --rm -v $(pwd)/src:/data cytopia/php-cs-fixer:3-php8.1 fix --dry-run --diff .

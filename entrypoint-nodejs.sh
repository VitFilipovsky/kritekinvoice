#!/bin/bash

cd /var/www/html/app

echo "Installing npm dependencies..."
npm install

echo "Starting webpack watch..."
while true; do
    npm run watch
    echo "Webpack watch exited (exit code: $?), restarting in 3 seconds..."
    sleep 3
done

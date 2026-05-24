#!/usr/bin/env sh
set -eu

PORT="${PORT:-10000}"
MAX_MIGRATION_ATTEMPTS="${MAX_MIGRATION_ATTEMPTS:-12}"
MIGRATION_SLEEP_SECONDS="${MIGRATION_SLEEP_SECONDS:-5}"

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is not set."
    exit 1
fi

export PORT
envsubst '${PORT}' < /etc/apache2/sites-available/render.conf.template > /etc/apache2/sites-available/000-default.conf
printf 'Listen %s\n' "$PORT" > /etc/apache2/ports.conf

mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

chown -R www-data:www-data bootstrap/cache storage

attempt=1
until php artisan migrate --force; do
    if [ "$attempt" -ge "$MAX_MIGRATION_ATTEMPTS" ]; then
        echo "Database migrations failed after $attempt attempts."
        exit 1
    fi

    echo "Database is not ready yet. Retrying in ${MIGRATION_SLEEP_SECONDS}s..."
    attempt=$((attempt + 1))
    sleep "$MIGRATION_SLEEP_SECONDS"
done

exec apache2-foreground


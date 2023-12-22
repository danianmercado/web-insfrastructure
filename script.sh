#!/bin/bash

install() {
    build
    up
    docker compose exec -T app composer install
    docker compose exec -T app cp .env.example .env
    docker compose exec -T app php artisan key:generate
    docker compose exec -T app php artisan storage:link
    docker compose exec -T app chmod -R 777 storage bootstrap/cache
    fresh
}

create_project() {
    mkdir -p src
    docker compose build
    docker compose up -d
    docker compose exec -T app composer create-project --prefer-dist laravel/laravel .
    docker compose exec -T app php artisan key:generate
    docker compose exec -T app php artisan storage:link
    docker compose exec -T app chmod -R 777 storage bootstrap/cache
    fresh
}

up() {
    docker compose up -d
}

build() {
    docker compose build
}

remake() {
    destroy
    install
}

stop() {
    docker compose stop
}

down() {
    docker compose down --remove-orphans
}

down_v() {
    docker compose down --remove-orphans --volumes
}

restart() {
    down
    up
}

destroy() {
    docker compose down --rmi all --volumes --remove-orphans
}

ps() {
    docker compose ps
}

logs() {
    docker compose logs
}

logs_watch() {
    docker compose logs --follow
}

log_web() {
    docker compose logs web
}

log_web_watch() {
    docker compose logs --follow web
}

log_app() {
    docker compose logs app
}

log_app_watch() {
    docker compose logs --follow app
}

log_db() {
    docker compose logs db
}

log_db_watch() {
    docker compose logs --follow db
}

web() {
    docker compose exec -T web bash
}

app() {
    docker compose exec -T app bash
}

migrate() {
    docker compose exec -T app php artisan migrate
}

fresh() {
    docker compose exec -T app php artisan migrate:fresh --seed
}

seed() {
    docker compose exec -T app php artisan db:seed
}

dacapo() {
    docker compose exec -T app php artisan dacapo
}

rollback_test() {
    docker compose exec -T app php artisan migrate:fresh
    docker compose exec -T app php artisan migrate:refresh
}

tinker() {
    docker compose exec -T app php artisan tinker
}

test() {
    docker compose exec -T app php artisan test
}

optimize() {
    docker compose exec -T app php artisan optimize
}

optimize_clear() {
    docker compose exec -T app php artisan optimize:clear
}

cache() {
    docker compose exec -T app composer dump-autoload -o
    optimize
    docker compose exec -T app php artisan event:cache
    docker compose exec -T app php artisan view:cache
}

cache_clear() {
    docker compose exec -T app composer clear-cache
    optimize_clear
    docker compose exec -T app php artisan event:clear
}

db() {
    docker compose exec -T db bash
}

sql() {
    docker compose exec -T db bash -c 'mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE'
}

redis() {
    docker compose exec -T redis redis-cli
}

ide_helper() {
    docker compose exec -T app php artisan clear-compiled
    docker compose exec -T app php artisan ide-helper:generate
    docker compose exec -T app php artisan ide-helper:meta
    docker compose exec -T app php artisan ide-helper:models --nowrite
}

"$@"  # Execute the function based on the provided command-line arguments

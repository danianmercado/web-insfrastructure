# docker-laravel 🐳

## Introduction

Build a  simple laravel development environment with docker-compose. Compatible with Windows(WSL2), macOS(M1) and Linux.

## Usage

### Laravel install

1. Execute the following command

```bash
$ mkdir -p src
$ docker compose build
$ docker compose up -d
$ docker compose exec app composer create-project --prefer-dist laravel/laravel .
$ docker compose exec app php artisan key:generate
$ docker compose exec app php artisan storage:link
$ docker compose exec app chmod -R 777 storage bootstrap/cache
$ docker compose exec app php artisan migrate
```

http://localhost

### Laravel setup

1. Git clone & change directory
2. Execute the following command

```bash
$ make install
```

http://localhost

## Tips

- Read this [Makefile](https://github.com/ucan-lab/docker-laravel/blob/main/Makefile).
- Read this [Wiki](https://github.com/ucan-lab/docker-laravel/wiki).

## Container structures

```bash
├── app
├── web
└── db
```

### app container

- Base image
  - [php](https://hub.docker.com/_/php):8.2-fpm-bullseye
  - [composer](https://hub.docker.com/_/composer):2.5

### web container

- Base image
  - [nginx](https://hub.docker.com/_/nginx):1.25

### db container

- Base image
  - [mysql/mysql-server](https://hub.docker.com/r/mysql/mysql-server):8.0

### mailpit container

- Base image
  - [axllent/mailpit](https://hub.docker.com/r/axllent/mailpit)
# web-insfrastructure

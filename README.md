# Shoes Demo

<p>
    <img src="http://localhost/data/img.png](https://sonhoang2071.site/data/img.png" alt="">
</p>

## Introduction

I build Shoes Project in Laravel development environment with Docker. Compatible with Windows(WSL2), macOS(M1) and Linux. Besides, I also using Jquery for develop UI

## Usage

### Create an initial Project

1. Execute the following command

```bash
$ make init

# or...

$ cp .env.example .env
$ cp /src/.env.example /src/.env
$ docker compose build
$ docker compose up -d
$ docker compose exec app composer install
$ docker compose exec app composer dump-autoload
$ docker compose exec app php artisan key:generate
$ docker compose exec app php artisan storage:link
$ docker compose exec app chmod -R 777 storage bootstrap/cache
$ docker compose exec app php artisan migrate
$ docker compose exec app php artisan db:seed --class=ShoesSeeder
```

http://localhost

## Project Structures

```bash
├── infra             -- docker file services
├── src               -- sources code laravel
├── .env              -- file env
├── compose.yml       -- docker-compose file
└── ...
```

### Infra Folder

```bash
├─ infra             
├─── docker
├────── mysql    
├────── nginx 
└────── php 
```
### Container structures
#### app container
-   Base image
    -   [php](https://hub.docker.com/_/php):8.3-fpm-bullseye
    -   [composer](https://hub.docker.com/_/composer):2.6

#### web container

-   Base image
    -   [nginx](https://hub.docker.com/_/nginx):1.25

####  db container

-   Base image
    -   [mysql/mysql-server](https://hub.docker.com/r/mysql/mysql-server):8.0


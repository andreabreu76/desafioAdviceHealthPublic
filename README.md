# Desafio Advice Health

## Objetivo

O Desafio consiste em fazer uma API RESTful para um sistema de TODO. Inlcuisndo um FRONT-END. Maiores detalhes podem ser vistos [aqui](docs/Desafio.md).

## Versões

Backend (API):

> PHP-fpm 8.1.2 (Dockerfile TAG: `8.1.2-fpm-buster`)
>
> Composer 2.2.6
>
> Laravel 8.83.0

Frontend (APP):

> NodeJS 14.19.0 (Dockerfile TAG: `14.19.0-buster`)
>
> Npm 6.14.16
>
> Vue/CLI 4.5.15
>
> Vue/Quasar 2.6.0

Database

> MariaDB 10.5.9 (Dockerfile TAG: `latest`)

Transport

> Nginx 1.20.0 (Dockerfile TAG: `latest`)

## Sistema

O sistema foi construido com o PHP-fpm, o Laravel, o MariaDB, o Nginx e o NodeJS. O frontend foi construido com o Vue/CLI e o Vue/Quasar. O backend foi construido com o Composer e o Laravel. O banco de dados foi construido com o MariaDB. O transporte foi construido com o Nginx. 

Todos os sistemas foram concebidos numa estrutura de microserviços, onde cada um é responsável por uma área do sistema. Utilizando containers Docker.

## Rodando a aplicação

### Estrutura

O diretorio raiz é o `/desafioadvicehealth` e dentro dele temos os seguintes diretorios:

    - `/desafioadvicehealth/api`
    - `/desafioadvicehealth/app`
    - `/desafioadvicehealth/docker`
    - `/desafioadvicehealth/docs`
    - `/desafioadvicehealth/docker-compose.yml`
    - `/desafioadvicehealth/README.md`

#### API

Micro serviço responsável por fazer o CRUD dos dados. E fornecer a API RESTful.

#### APP

Micro serviço responsável por fazer o frontend.

#### DOCKER

Contém os arquivos necessários para o Docker construir suas imagens.

#### DOCKER-COMPOSE.YML

Arquivo responsavel pela inicialização dos consteiners e sua rede.


#### README.MD

Este descritivo.


### Preaprando o Sistema

Se você tem em seu sistema o Docker, caso não, veremos outra forma de iniciar a frente. No diretorio `/desafioadvicehealth`:

```bash
cp ./api/.env.example ./api/.env
```
```bash
docker-compose up -d
```
```bash
cd api/
```
```bash
docker exec -it advicehealth-api composer install
```
```bash
docker exec -it advicehealth-api php artisan config:clear
```
```bash
docker exec -it advicehealth-api php artisan cache:clear
```
```bash
docker exec -it advicehealth-api php artisan migrate --seed
```


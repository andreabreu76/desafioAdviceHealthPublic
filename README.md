# Desafio Advice Helth

## Instalação

```bash
git clone https://github.com/andreabreu76/desafioAdviceHealth desafioAdviceHealth
```

### APP - Frontend
```bash
cd desafioAdviceHealth/app  && docker exec -it advicehealth_api php artisan key:generate
```

```bash
cd ../
```

### API - Backend

```bash
cd desafioAdviceHealth/api && composer install
``` 

```bash
cp .evn.example .env
```

```bash
docker-compose up -d
```

```bash
docker exec -it advicehealth_api php artisan config:clear
```

```bash
docker exec -it advicehealth_api php artisan key:generate
```

```bash
docker exec -it advicehealth_api php artisan migration --seed
```

```bash
docker exec -it advicehealth_api php artisan optimize
```


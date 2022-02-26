# Desafio Advice Helth

## Instalação

```bash
git clone https://github.com/andreabreu76/desafioAdviceHealth desafioAdviceHealth
```

### APP - Frontend
```bash
cd desafioAdviceHealth/app  && npm install
```

```bash
cd ../
```

### API - Backend

```bash
cd desafioAdviceHealth/api && composer install
``` 

```bash
cp .env.example .env
```

```bash
docker-compose up -d
```

```bash
docker exec -it advicehealth-api php artisan config:clear
```

```bash
docker exec -it advicehealth_api php artisan key:generate
```

```bash
docker exec -it advicehealth_api php artisan migrate --seed
```

```bash
docker exec -it advicehealth_api php artisan optimize
```

```bash
cd ../../
```

```bash
chown -R $USER:$USER desafioAdviceHealth/
```


## Endpoints

Frontend: http://localhost


Backend: 

- List All/GET: http://localhost/srv/api/todos
- List One/GET: http://localhost/srv/api/todos/{id}
- Create/POST: http://localhost/srv/api/todos
- Update/PUT: http://localhost/srv/api/todos/{id}
- Delete/Delete: http://localhost/srv/api/todos/{id}



Enjoy!

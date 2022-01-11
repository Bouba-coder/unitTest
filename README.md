### Getting started
##you may have docker in your machine
```bash
docker-compose build --pull --no-cache
docker-compose up -d
```

```
# URL
http://127.0.0.1

# Env DB
DATABASE_URL="postgresql://postgres:password@db:5432/db?serverVersion=13&charset=utf8"
```

#run all test
docker-compose exec php bin/phpunit

##if you want run test with composer
composer run-test

#run bash shell docker (if you want) test_unitaire_php_1 = image name
docker exec -it test_unitaire_php_1  /bin/bash
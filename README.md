when launching it for the first time run the following command to create the (mariadb)mysql table
```docker exec -ti place-backend_laravel.test_1 php artisan migrate```





# p5-place
This is inspired by the reddit game called place.
This repo is for the server side of the solution.
##

## Project setup
```
docker exec place-backend_laravel.test_1 php artisan migrate
```

### Compiles and hot-reloads for development
requires:
docker
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
launch app on port 8001
```
APP_PORT=8001 ./vendor/bin/sail up -d    
```

### env file
```
APP_NAME=app_name
APP_ENV=local
APP_KEY=app_key
APP_DEBUG=true
APP_URL=app_url

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=place_backend
DB_USERNAME=sail
DB_PASSWORD=password

CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=memcached

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=app_id
PUSHER_APP_KEY=app_key
PUSHER_APP_SECRET=secret_key
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

```

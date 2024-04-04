# Transaction API

## Requirements

PHP >8.2

Composer

Docker

## Installation

```shell
APP_PORT=8080 ./vendor/bin/sail up -d
```

```shell
./vendor/bin/sail artisan migrate
```

```shell
./vendor/bin/sail artisan l5-swagger:generate
```

## Access

[http://localhost:8080](http://localhost:8080)


## Documentation swagger

[http://localhost:8080/api/documentation](http://localhost:8080/api/documentation)

## Tests

```shell
./vendo/bin/sail artisan test
```

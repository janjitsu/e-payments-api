E Payments API
==============
[![Build
Status](https://circleci.com/gh/janjitsu/e-payments-api/tree/master.png?style=shield&circle-token=be171ecb992c97936ed1e465b08713e37ff0750b)](https://circleci.com/gh/janjitsu/e-payments-api)

Backend api for [e-payments](https://github.com/glauroqj/e-payments)

---

## Running

### Start containers
```
$ docker-compose up -d
```

### Run demo page
```
http://localhost:8000
```

### Install packages
```
$ docker exec -t epayments-fpm composer install
```

### Running tests
```
$ docker exec -t epayments-fpm bin/phpunit
```


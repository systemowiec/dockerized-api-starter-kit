### Dockerized API Starter Kit

## Dependencies

```virtualbox, docker, docker-compose```

## Installation

```git clone git@github.com:systemowiec/dockerized-api-starter-kit.git```

```docker-compose up -d```

```docker-compose exec php-dev composer install```

**Never use Staging/Live Database in parameters_e2e.yml file!**

## Usage

Run tests:

```bin/phpspec run```

```docker-compose exec php bin/behat -p domain```

```docker-compose exec php bin/behat -p e2e```

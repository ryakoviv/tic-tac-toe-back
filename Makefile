EXEC_PHP ?= docker-compose exec php

cache-clear:
	$(EXEC_PHP) php bin/console cache:clear

vendor:
	$(EXEC_PHP) composer install

vendor-update:
	$(EXEC_PHP) composer update

migrate:
	$(EXEC_PHP) php bin/console doctrine:migrations:migrate

tests:
	$(EXEC_PHP) composer test

metrics:
	$(EXEC_PHP) composer metrics

build:
	docker-compose build

start:
	docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

run:
	make build
	make start
	make vendor

phpstan: vendor ## PHPStan (https://github.com/phpstan/phpstan)
	$(EXEC_PHP) composer phpstan

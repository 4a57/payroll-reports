build:
	docker-compose build
	docker-compose run --rm app composer install

start: stop
	docker-compose up -d

stop:
	docker-compose down

cli-php:
	docker-compose run --rm app bash

run-tests:
	docker-compose run --rm app php vendor/bin/phpunit

build:
	docker-compose build
	docker-compose run --rm app composer install

start: stop
	docker-compose up -d

stop:
	docker-compose down

cli-php:
	docker-compose run --rm app bash

run-tests: init-tests simple-tests

init-tests: stop-tests
	docker-compose -f docker-compose-test.yml up -d
	docker-compose -f docker-compose-test.yml exec -e APP_ENV=test test-app php bin/console doctrine:schema:create

stop-tests:
	docker-compose -f docker-compose-test.yml down

simple-tests:
	docker-compose -f docker-compose-test.yml exec test-app php vendor/bin/phpunit


cli-php-test:
	docker-compose -f docker-compose-test.yml exec test-app bash
build:
	docker-compose build

start: stop
	docker-compose up -d

stop:
	docker-compose down

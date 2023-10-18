build:
	docker-compose build --progress plain

start:
	docker-compose up -d

stop:
	docker-compose down -v

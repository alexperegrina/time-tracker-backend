docker-db-start:
	docker-compose build db
	docker-compose up -d db

docker-db-stop:
	docker stop time-tracker-bd
SHELL := /bin/bash

APP_NAME ?= gpdb

.PHONY: down install up

install:
	touch database/database.sqlite
	composer install
	composer run-script post-root-package-install
	composer run-script post-create-project-cmd
	php artisan migrate

up:
	docker-compose -p $(APP_NAME) -f compose.yml up -d webserver

down:
	docker-compose -p $(APP_NAME) -f compose.yml kill
	docker-compose -p $(APP_NAME) -f compose.yml rm -f
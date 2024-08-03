# Comando base para docker-compose
DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml

## ---------------------------------------------------------
## Inicialización de la Aplicación
## ---------------------------------------------------------

.PHONY: init-app
init-app: | copy-env up

.PHONY: copy-env
copy-env:
	@cd ./docker && [ ! -f .env ] && cp .env.example .env

## ---------------------------------------------------------
## Gestión de Contenedores
## ---------------------------------------------------------

.PHONY: content-apache
content-apache:
	docker exec -it php-apache-pablogarciajc bash

.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

.PHONY: down
down:
	$(DOCKER_COMPOSE) down

.PHONY: restart
restart:
	$(DOCKER_COMPOSE) restart

.PHONY: ps
ps:
	$(DOCKER_COMPOSE) ps

.PHONY: logs
logs:
	$(DOCKER_COMPOSE) logs

.PHONY: build
build:
	$(DOCKER_COMPOSE) build

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) stop

## ---------------------------------------------------------
## Comando base para docker-compose
## ---------------------------------------------------------

DOCKER_COMPOSE = docker-compose -f ./.docker/docker-compose.yml

## ---------------------------------------------------------
## Inicialización de la Aplicación
## ---------------------------------------------------------

.PHONY: init-app
init-app: | copy-env set-permissions create-symlink up

.PHONY: copy-env
copy-env:
	@ [ ! -f .env ] && cp .env.example .env

.PHONY: set-permissions
set-permissions:
	@chmod -R 777 ./config/.log
	@chmod g+s ./config/.log

.PHONY: create-symlink
create-symlink:
	@ [ -L .docker/.env ] || ln -s ../.env .docker/.env


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

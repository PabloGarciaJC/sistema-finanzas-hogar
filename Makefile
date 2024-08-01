DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml

## Inicia el sistema desde cero
.PHONY: init-app
init-app: | copy-env up

.PHONY: copy-env
copy-env: # Copia .env.example a .env si no existe
	@cd ./docker && [ ! -f .env ] && cp .env.example .env

.PHONY: content-apache
content-apache:
	docker exec -it php-apache-pablogarciajc bash

# Objetivo para levantar los contenedores
.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

# Objetivo para bajar los contenedores
.PHONY: down
down:
	$(DOCKER_COMPOSE) down

# Objetivo para reiniciar los contenedores
.PHONY: restart
restart:
	$(DOCKER_COMPOSE) restart

# Objetivo para ver el estado de los contenedores
.PHONY: ps
ps:
	$(DOCKER_COMPOSE) ps

# Objetivo para ver los logs de los contenedores
.PHONY: logs
logs:
	$(DOCKER_COMPOSE) logs

# Objetivo para construir imágenes
.PHONY: build
build:
	$(DOCKER_COMPOSE) build

# Objetivo para detener los contenedores
.PHONY: stop
stop:
	$(DOCKER_COMPOSE) stop


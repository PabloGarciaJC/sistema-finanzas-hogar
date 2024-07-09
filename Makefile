# Variables para el comando docker-compose
DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml

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

# Objetivo para limpiar contenedores, volúmenes y redes
.PHONY: clean
clean:
	$(DOCKER_COMPOSE) down -v --remove-orphans

# Objetivo para ejecutar un shell interactivo en el contenedor php-apache-pablogarciajc
.PHONY: container-php-server
container-php-server:
	$(DOCKER_COMPOSE) exec php_apache_server /bin/bash

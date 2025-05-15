## ---------------------------------------------------------
## Comando base para docker-compose
## ---------------------------------------------------------

DOCKER_COMPOSE = docker compose -f ./.docker/docker-compose.yml

## ---------------------------------------------------------
## Inicialización de la Aplicación Symfony
## ---------------------------------------------------------

.PHONY: init-app
init-app: | copy-env create-symlink up permissions print-urls

.PHONY: copy-env
copy-env:
	@ [ ! -f .env ] && cp .env.example .env || true

.PHONY: permissions
permissions:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar chmod -R 777 var
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar chmod -R 777 public
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar chmod -R 777 templates

.PHONY: create-symlink
create-symlink:
	@ [ -L .docker/.env ] || ln -s ../.env .docker/.env

.PHONY: print-urls
print-urls:
	@echo "## Acceso a la Aplicación:   http://localhost:8081/"
	@echo "## Acceso a PhpMyAdmin:      http://localhost:8082/"

## ---------------------------------------------------------
## Symfony - Instalación
## ---------------------------------------------------------

.PHONY: symfony-install
symfony-install:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar bash -c "\
		git config --global --add safe.directory /var/www/html && \
		composer create-project symfony/skeleton symfony \
	"

## ---------------------------------------------------------
## Symfony - Configuración de Componentes
## ---------------------------------------------------------

# Trabajar con plantillas
.PHONY: require-twig
require-twig:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require twig

# ORM (gestión de bases de datos)
require-orm-pack:
	docker compose -f ./.docker/docker-compose.yml exec php_apache_finanzas_hogar composer require symfony/orm-pack

# Depuración en desarrollo
.PHONY: require-debug
require-debug:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require --dev symfony/debug-bundle

# Paquete para generar automáticamente código (controladores, entidades, etc.)
.PHONY: require-maker
require-maker:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require --dev symfony/maker-bundle

# Paquete EasyAdmin Bundle para la administración del panel en Symfony
.PHONY: require-easyadmin
require-easyadmin:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require easycorp/easyadmin-bundle

## ---------------------------------------------------------
## Gestión de Contenedores
## ---------------------------------------------------------

# si sebe de crear una condicional para verificar que si ya existe urls. no la ejecute dos veces
.PHONY: up 
up:
	$(DOCKER_COMPOSE) up -d
	@$(MAKE) --no-print-directory print-urls

.PHONY: down
down:
	$(DOCKER_COMPOSE) down

.PHONY: build
build:
	$(DOCKER_COMPOSE) build

.PHONY: shell
shell:
	$(DOCKER_COMPOSE) exec --user pablogarciajc php_apache_finanzas_hogar /bin/sh -c "cd /var/www/html/; exec bash -l"

.PHONY: clean-docker
clean-docker:
	sudo docker stop $$(sudo docker ps -q) || true
	sudo docker rm $$(sudo docker ps -a -q) || true
	sudo docker rmi -f $$(sudo docker images -q) || true
	sudo docker volume rm $$(sudo docker volume ls -q) || true

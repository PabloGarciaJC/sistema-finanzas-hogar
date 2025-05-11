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

.PHONY: require-twig #templates
require-twig:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require twig

# .PHONY: console
# console:
# 	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console

.PHONY: migrate
migrate:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console doctrine:migrations:migrate

.PHONY: rollback
rollback:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console doctrine:migrations:rollback

# .PHONY: make-controller
# make-controller:
# 	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console make:controller

# .PHONY: make-entity
# make-entity:
# 	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console make:entity

# .PHONY: make-migration
# make-migration:
# 	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console make:migration

## ---------------------------------------------------------
## Gestión de Contenedores
## ---------------------------------------------------------

.PHONY: up 
up:
	$(DOCKER_COMPOSE) up -d
	@$(MAKE) --no-print-directory print-urls

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

.PHONY: shell
shell:
	$(DOCKER_COMPOSE) exec --user pablogarciajc php_apache_finanzas_hogar /bin/sh -c "cd /var/www/html/; exec bash -l"

.PHONY: clean-docker
clean-docker:
	sudo docker stop $$(sudo docker ps -q) || true
	sudo docker rm $$(sudo docker ps -a -q) || true
	sudo docker rmi -f $$(sudo docker images -q) || true
	sudo docker volume rm $$(sudo docker volume ls -q) || true

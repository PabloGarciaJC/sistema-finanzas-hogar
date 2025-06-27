## ---------------------------------------------------------
## Comando base para docker-compose
## ---------------------------------------------------------

DOCKER_COMPOSE = docker compose -f ./.docker/docker-compose.yml

## ---------------------------------------------------------
## Inicialización de la Aplicación Symfony
## ---------------------------------------------------------

.PHONY: init-app
init-app: | copy-env create-symlink up permissions migracion print-urls

.PHONY: copy-env
copy-env:
	@ [ ! -f .env ] && cp .env.example .env || true

.PHONY: permissions
permissions:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar chmod -R 777 public
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar chmod -R 777 templates
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer install
	$(DOCKER_COMPOSE) exec --user pablogarciajc php_apache_finanzas_hogar npm install

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

.PHONY: require-twig
require-twig:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require twig

require-orm-pack:
	docker compose -f ./.docker/docker-compose.yml exec php_apache_finanzas_hogar composer require symfony/orm-pack

.PHONY: require-debug
require-debug:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require --dev symfony/debug-bundle

.PHONY: require-maker
require-maker:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require --dev symfony/maker-bundle

.PHONY: require-easyadmin
require-easyadmin:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar composer require easycorp/easyadmin-bundle

## ---------------------------------------------------------
## Symfony - Base de Datos y Migraciones
## ---------------------------------------------------------

.PHONY: migracion
migracion:
	@echo "⏳ Esperando a que MySQL esté disponible..."
	@sleep 5
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console doctrine:migrations:migrate --no-interaction
	@$(MAKE) fixtures-load
	@echo "Migraciones y fixtures aplicadas!"

.PHONY: generate-migration
generate-migration:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console doctrine:migrations:generate

.PHONY: sync-metadata
sync-metadata:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console doctrine:migrations:sync-metadata-storage

.PHONY: fixtures-load
fixtures-load:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console doctrine:fixtures:load --no-interaction --env=dev

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

.PHONY: build
build:
	$(DOCKER_COMPOSE) build

.PHONY: shell
shell:
	$(DOCKER_COMPOSE) exec --user pablogarciajc php_apache_finanzas_hogar /bin/sh -c "cd /var/www/html/; exec bash -l"

.PHONY: rollback
rollback:
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console doctrine:migrations:migrate 0

.PHONY: clean-docker
clean-docker:
	sudo docker stop $$(sudo docker ps -q) || true
	sudo docker rm $$(sudo docker ps -a -q) || true
	sudo docker rmi -f $$(sudo docker images -q) || true
	sudo docker volume rm $$(sudo docker volume ls -q) || true

.PHONY: npm-dev
npm-dev:
	$(DOCKER_COMPOSE) exec --user pablogarciajc php_apache_finanzas_hogar npm run dev

.PHONY: cache-prod
cache-prod:
	$(DOCKER_COMPOSE) exec --user pablogarciajc php_apache_finanzas_hogar npm run build
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console cache:clear --env=prod
	$(DOCKER_COMPOSE) exec php_apache_finanzas_hogar php bin/console cache:warmup --env=prod

.PHONY: push-build
push-build:
	git add -f public/build
	git commit -m "Agrego assets compilados para producción"
	git push origin master



# php bin/console make:fixture CurrencyFixture
# php bin/console doctrine:fixtures:load

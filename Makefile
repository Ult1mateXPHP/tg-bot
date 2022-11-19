SERVICE_NAME=php
DC=docker-compose -f docker-compose.yml
DCE=${DC} exec ${SERVICE_NAME}
PHP=${DCE} php
COMPOSER=${DCE} composer
CONSOLE=${PHP} bin/console
PSALM=${PHP} vendor/bin/psalm
BEHAT=${PHP} vendor/bin/behat

console:
	${CONSOLE}

in:
	${DC} exec php bash

###> DOCKER COMPOSE
restart: down up
start:
	${DC} start
stop:
	${DC} stop
up:
	${DC} up -d
down:
	${DC} down

build:
ifdef nc
	${DC} build --no-cache ${arg}
else
	${DC} build ${arg}
endif
###< DOCKER COMPOSE

###> COMPOSER
cr:  composer-require
crd: composer-require-dev
ci:  composer-install
cu:  composer-update
cul: composer-update-lock
composer-require-dev:
	${COMPOSER} require --dev ${arg}
composer-require:
	${COMPOSER} require ${arg}
composer-install:
	${COMPOSER} install
composer-update:
	${COMPOSER} update
composer-update-lock:
	${COMPOSER} update --lock
composer-dump:
	${COMPOSER} dump-autoload
###< COMPOSER

###> DEBUG
debug-autowiring:
	${CONSOLE} debug:autowiring
debug-config:
	${CONSOLE} debug:config
debug-container:
	${CONSOLE} debug:container
debug-event-dispatcher:
	${CONSOLE} debug:event-dispatcher
debug-router:
	${CONSOLE} debug:router
debug-validator:
	${CONSOLE} debug:validator
###< DEBUG

###> CACHE
cc: cache-clear
cache-clear:
ifdef env
	${CONSOLE} cache:clear -e $(env)
else
	${CONSOLE} cache:clear
endif

###< CACHE

###> SWAGGER
swagger:
	${CONSOLE} nelmio:apidoc:dump > public/bundles/nelmioapidoc/swagger.json
###< SWAGGER

###> PSALM
psalm-cache-clear:
	${PSALM} --clear-cache
psalm:
	${PSALM}
psalm-ci:
	${PSALM} -c psalm-ci.xml --report=results.sarif
###< PSALM

###> BEHAT
behat:
	${BEHAT} -c behat.yml
###< BEHAT

###> CODE_SNIFFER
lint:
	${PHP} vendor/bin/phpcs --standard=phpcs.xml --runtime-set ignore_warnings_on_exit 1
lint-fix:
	${PHP} vendor/bin/phpcbf --standard=phpcs.xml
###< CODE_SNIFFER

### develop migrations ###
refresh:
	${CONSOLE} doctrine:migrations:migrate first -n
	${CONSOLE} doctrine:migrations:migrate -n

refresh-fixtures:
	${CONSOLE} doctrine:migrations:migrate first -n
	${CONSOLE} doctrine:migrations:migrate -n
	${CONSOLE} doctrine:fixtures:load -n

reload-fixtures:
	${CONSOLE} doctrine:database:drop --force
	${CONSOLE} doctrine:database:create
	${CONSOLE} doctrine:migrations:migrate --no-interaction
	${CONSOLE} doctrine:fixtures:load --no-interaction

reload-fixtures-test:
	${CONSOLE} doctrine:database:drop -e test --force
	${CONSOLE} doctrine:database:create -e test
	${CONSOLE} doctrine:migrations:migrate -e test --no-interaction
	${CONSOLE} doctrine:fixtures:load -e test --no-interaction
### develop migrations ###

kek:
	${COMPOSER} install --no-progress --no-scripts
	${COMPOSER} dump-autoload
	${PSALM} --no-cache --no-progress --output-format=phpstorm -c psalm-ci.xml
	#${CONSOLE} nelmio:apidoc:dump > public/bundles/nelmioapidoc/swagger.json
	${CONSOLE} doctrine:database:drop -e test --force
	${CONSOLE} doctrine:database:create -e test
	${CONSOLE} doctrine:migrations:migrate -e test --no-interaction
	${CONSOLE} doctrine:fixtures:load -e test --no-interaction
	${PHP} vendor/bin/phpunit --configuration phpunit.xml
	${BEHAT} -c behat.yml



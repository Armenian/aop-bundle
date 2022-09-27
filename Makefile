-include .env

DOCKER_COMPOSE ?= docker-compose
EXECUTE_APP ?= $(DOCKER_COMPOSE) exec php-fpm
COMPOSER ?= $(EXECUTE_APP) composer

all: install test
.PHONY: all

# target: [install] - Install
install: up cs-install
.PHONY: install

# target: [build] - Build docker
build:
	$(DOCKER_COMPOSE) build
.PHONY: build

# target: [restart] - Restart docker
restart:
	$(DOCKER_COMPOSE) restart
.PHONY: restart

# target: [stop] - Stop docker
stop:
	$(DOCKER_COMPOSE) stop
.PHONY: stop

# target: [up] - UP docker
up:
	$(DOCKER_COMPOSE) up --remove-orphans -d
.PHONY: up

# target: [logs] - Show docker logs
logs:
	$(DOCKER_COMPOSE) logs -f
.PHONY: logs

# target: [pull] - Docker pull
pull:
	$(DOCKER_COMPOSE) pull
.PHONY: pull

# target: [down] - Down Docker
down:
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: down

# target: [ssh] - Open SSH connection with php-fpm container
ssh:
	$(EXECUTE_APP) bash
.PHONY: ssh

# target: [cs-update p=] - Composer update
cs-update:
	$(COMPOSER) update $(p)
.PHONY: cs-update

# target: [cs-req p=] - Composer require
cs-req:
	$(COMPOSER) require $(p)
.PHONY: cs-req

# target: [cs-req-dev p=] - Composer require --dev
cs-req-dev:
	$(COMPOSER) require --dev $(p)
.PHONY: cs-req-dev

# target: [cs-install] - Composer install
cs-install:
	$(COMPOSER) install --apcu-autoloader
.PHONY: cs-install

# target: [cs-show] - Composer show
cs-show:
	$(COMPOSER) show -v
.PHONY: cs-show

# target: [test] - Run PHPUnit tests on php-fpm container
test:
	$(COMPOSER) test
.PHONY: test

# target: [test-cc] - Run PHPUnit tests on php-fpm container
test-cc:
	$(COMPOSER) test-cc
.PHONY: test-cc

# target: [help] - Display callable targets
help:
	egrep "^# target:" [Mm]akefile
.PHONY: help

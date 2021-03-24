isDocker := $(shell docker info > /dev/null 2>&1 && echo 1)
user := $(shell id -u)
group := $(shell id -g)

ifeq ($(isDocker), 1)
	dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose
	de := docker-compose exec
	dr := $(dc) run --rm
	php := $(dr) --no-deps php
else
	php :=
endif

.DEFAULT_GOAL := help
.PHONY: help
help: ## Display this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'


.PHONY: install
install: vendor/autoload.php ## Install dependencies
	APP_ENV=prod APP_DEBUG=0 $(php) composer install --no-dev --optimize-autoloader
	make migrate

.PHONY: build-docker
build-docker:
	$(dc) pull --ignore-pull-failures
	$(dc) build

.PHONY: dev
dev: vendor/autoload.php ## Launch dev server
	$(dc) up


#.PHONY: seed
#seed: vendor/autoload.php ## Launch database migrations
#	$(sy) doctrine:migrations:migrate -q
#	$(sy) app:seed -q



# -----------------------------------
# Dependencies
# -----------------------------------
composer.lock: composer.json
	composer update

vendor/autoload.php: composer.lock
	$(php) composer install
	touch vendor/autoload.php

var/dump:
	mkdir var/dump



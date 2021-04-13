isDocker := $(shell docker info > /dev/null 2>&1 && echo 1)
user := $(shell id -u)
group := $(shell id -g)

# Read .env file
ifneq (,$(wildcard ./.env))
    include .env
    export
endif

ifeq ($(isDocker), 1)
	dc := USER_ID=$(user) GROUP_ID=$(group) docker-compose
	de := docker-compose exec
	dr := $(dc) run --rm
	php := $(dr) --no-deps php
	composer := $(php) composer
else
	php :=
	composer := php composer
endif

.DEFAULT_GOAL := help
.PHONY: help
help: ## Display this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo 'See also https://getcomposer.org/download/ to install composer on your web host'


.PHONY: install
install: vendor/autoload.php ## Install dependencies
	$(composer) install --no-dev --optimize-autoloader

.PHONY: build
build: ## Build docker images
	$(dc) pull --ignore-pull-failures
	$(dc) build

.PHONY: dev
dev: vendor/autoload.php setpermissions ## Launch dev server
	$(dc) up

.PHONY: configure
configure:  ## Configure defaults settings for the portfolio
	$(php) wp rewrite structure '/%postname%' --allow-root; $(php) wp site switch-language fr_FR --allow-root; $(php) wp theme activate portfolio --allow-root; $(php) wp portfolio fake_defaults --allow-root;

.PHONY: fake
fake:  ## Generate fakes cases studies for the example
	$(php) wp portfolio fake_casestudy --allow-root; $(php) wp rewrite flush --allow-root;

.PHONY: deploy
deploy: ## Deploy a new version from git
	ssh -A ${WEB_DESTINATION} -p ${WEB_SSHPORT} 'cd ${WEB_FOLDER} && git pull origin master && make install'

.PHONY: push
push: ## Push your local folder on server (only for tests purpose, prefer deploy in production)
	rsync -avz -e "ssh -p ${WEB_SSHPORT}" --progress --exclude 'web/app/uploads' . ${WEB_DESTINATION}:${WEB_FOLDER}/

.PHONY: test
test: ## test commande
	@echo "use this test command if you want to test your makefile syntax"


# -----------------------------------
# Dependencies
# -----------------------------------
composer.lock: composer.json
	composer update

vendor/autoload.php: composer.lock
	$(composer) install
	$(php) touch vendor/autoload.php

setpermissions: #Please, don't do that in production!!!
	chmod 777 web/app/uploads

var/dump:
	mkdir var/dump



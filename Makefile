help: ## Show this help
	@echo Usage: make [target]
	@echo
	@echo Targets:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-20s %s\n", $$1, $$2}'

init: ## initialize project
	bash init-project.sh

php: ## php docker container
	docker exec -ti kritekinvoice_php /bin/bash

mysql: ## mysql docker container
	docker exec -ti kritekinvoice_mysql /bin/bash

node: ## node docker container
	docker exec -ti kritekinvoice_node /bin/bash

composer-install: ## install composer dependencies
	docker exec kritekinvoice_php bash -c 'cd /var/www/html/app && composer install'

composer-update: ## install composer dependencies
	docker exec kritekinvoice_php bash -c 'cd /var/www/html/app && composer update'

npm-install: ## install npm dependencies
	docker exec kritekinvoice_node bash -c 'cd /var/www/html/app && npm install'

npm-build: ## build assets for production
	docker exec kritekinvoice_node bash -c 'cd /var/www/html/app && npm run build'

npm-watch: ## start webpack watch (dev)
	docker exec kritekinvoice_node bash -c 'cd /var/www/html/app && npm run watch'

phpcs: ## php formating controll
	bash docker/phpcs/phpcs.sh

phpcs-fix: ## php formating controll run
	bash docker/phpcs/phpcs-fix.sh

phpstan: ## runs phpstan
	docker run --rm -v .:/kritekinvoice ghcr.io/phpstan/phpstan:2-php8.4 analyse -c /kritekinvoice/phpstan.neon

cache-clear cc: ## clear Symfony cache (run inside PHP container)
	docker exec kritekinvoice_php bash -c 'cd /var/www/html/app && php bin/console cache:clear'

debug-env: ## show which .env files Symfony loads and DATABASE_URL value
	docker exec kritekinvoice_php bash -c 'cd /var/www/html/app && php bin/console debug:dotenv'

help: ## Show this help
	@echo Usage: make [target]
	@echo
	@echo Targets:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-20s %s\n", $$1, $$2}'

php: ## php docker container
	docker exec -ti kritekinvoice_php /bin/bash

mysql: ## mysql docker container
	docker exec -ti kritekinvoice_mysql /bin/bash

node: ## node docker container
	docker exec -ti kritekinvoice_node /bin/bash

composer-install: ## install composer dependencies
	docker compose run --rm php composer install

phpcs: ## php formating controll
	bash docker/phpcs/phpcs.sh

phpcs-fix: ## php formating controll run
	bash docker/phpcs/phpcs-fix.sh

phpstan: ## runs phpstan
	docker run --rm -v .:/kritekinvoice ghcr.io/phpstan/phpstan analyse -c /kritekinvoice/phpstan.neon /kritekinvoice/src

test: ## runs phpunit tests
	docker exec -i kritekinvoice_php ./vendor/bin/phpunit

test-filter: ## runs specific phpunit test (usage: make test-filter FILTER=testName)
	docker exec -i kritekinvoice_php ./vendor/bin/phpunit --filter $(FILTER)

cache-clear cc: ## clear Symfony cache (run inside PHP container)
	docker exec kritekinvoice_php bash -c 'cd /var/www/html/app && php bin/console cache:clear'

debug-env: ## show which .env files Symfony loads and DATABASE_URL value
	docker exec kritekinvoice_php bash -c 'cd /var/www/html/app && php bin/console debug:dotenv'

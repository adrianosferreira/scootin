build:
	@echo "==================================================="
	@echo "== Setting up containers =="
	@echo "==================================================="
	cd docker && docker-compose down;
	cd docker && docker-compose up -d;
	@echo "==================================================="
	@echo "== Installing Composer Dependencies =="
	@echo "==================================================="
	cd docker && docker exec php-fpm composer install
	@echo "==================================================="
	@echo "== Running migrations =="
	@echo "==================================================="
	cd docker && docker exec php-fpm ./vendor/bin/doctrine-migrations migrate
install:
	composer install

lint:
	composer run-script phpcs -- --standard=PSR12 routes

lint-fix:
	composer run-script phpcbf -- --standard=PSR12 routes

test:
	composer run-script phpunit tests

run:
	php artisan serve

dumpautoload:
	composer dump-autoload --optimize

start:
	php artisan serve --host 0.0.0.0

install:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate:fresh --seed
	npm ci
	npm run build

watch:
	npm run watch

migrate:
	php artisan migrate:fresh

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes lang

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 app tests

test-coverage:
	XDEBUG_MODE=coverage php artisan test --coverage-clover build/logs/clover.xml

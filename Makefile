install:
	composer install

autoload:
	composer dump-autoload

lint:
	composer exec 'phpcs --standard=PSR2 src tests --ignore=tests/fixtures'
	php ./scripts/psrlint src src/Linter/Rules

test:
	composer exec 'phpunit tests'

install:
	composer install

autoload:
	composer dump-autoload

lint:
	composer exec 'phpcs --standard=PSR2 src tests --ignore=tests/fixtures'
	./scripts/psrlint src

test:
	composer exec 'phpunit tests'

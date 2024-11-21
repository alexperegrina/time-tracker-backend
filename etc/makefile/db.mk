db-create:
	@php bin/console doctrine:database:create

db-drop:
	@php bin/console doctrine:database:drop --force

db-migrate:
	@php bin/console doctrine:migrations:migrate --no-interaction

db-fixture:
	@php bin/console doctrine:fixtures:load --append

db-schema:
	@php bin/console doctrine:schema:create

db-init:
	@make --no-print-directory db-create
	@make --no-print-directory db-schema
	@make --no-print-directory db-fixture

db-reset:
	@make --no-print-directory db-drop
	@make --no-print-directory db-init

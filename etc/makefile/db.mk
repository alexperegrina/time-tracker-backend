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

#----- Test

db-create-test:
	@php bin/console doctrine:database:create --env=test

db-drop-test:
	@php bin/console doctrine:database:drop --force --env=test

db-migrate-test:
	@php bin/console doctrine:migrations:migrate --no-interaction --env=test

db-fixture-test:
	@php bin/console doctrine:fixtures:load --append --env=test

db-schema-test:
	@php bin/console doctrine:schema:create --env=test

db-init-test:
	@make --no-print-directory db-create-test
	@make --no-print-directory db-schema-test
	@make --no-print-directory db-fixture-test

db-reset-test:
	@make --no-print-directory db-drop-test
	@make --no-print-directory db-init-test


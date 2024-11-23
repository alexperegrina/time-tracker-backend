########################################################
DOCTRINE_OPTIONS=--env=$(ENV)
########################################################

db-create:
	@$(PHP_CONSOLE) doctrine:database:create $(DOCTRINE_OPTIONS)

db-drop:
	@$(PHP_CONSOLE) doctrine:database:drop --force $(DOCTRINE_OPTIONS)

db-migrate:
	@$(PHP_CONSOLE) doctrine:migrations:migrate --no-interaction $(DOCTRINE_OPTIONS)

db-fixture:
	@$(PHP_CONSOLE) doctrine:fixtures:load --append $(DOCTRINE_OPTIONS)

db-schema:
	@$(PHP_CONSOLE) doctrine:schema:create $(DOCTRINE_OPTIONS)

db-init:
	@make --no-print-directory db-create ENV=$(ENV)
	@make --no-print-directory db-schema ENV=$(ENV)
	@make --no-print-directory db-fixture ENV=$(ENV)

db-reset:
	@make --no-print-directory db-drop ENV=$(ENV)
	@make --no-print-directory db-init ENV=$(ENV)

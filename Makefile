include etc/makefile/db.mk
include etc/makefile/test.mk

first-env:
	composer install
	@make --no-print-directory db-init

init-env:
	@make --no-print-directory db-init

restore-env:
	@make --no-print-directory db-reset

#----- Test

init-env-test:
	@make --no-print-directory db-init-test

restore-env-test:
	@make --no-print-directory db-reset-test

include etc/makefile/db.mk

first-env:
	composer install
	@make --no-print-directory db-init

init-env:
	@make --no-print-directory db-init

restore-env:
	@make --no-print-directory db-reset

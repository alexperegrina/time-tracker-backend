########################################################
MKFILE_PATH := $(abspath $(lastword $(MAKEFILE_LIST)))
ROOT_DIR := $(dir $(MKFILE_PATH))
CURRENT_DIR := $(notdir $(patsubst %/,%,$(dir $(MKFILE_PATH))))
ENV=dev
PHP_CONSOLE=php bin/console
########################################################

include etc/makefile/db.mk
include etc/makefile/test.mk
include etc/makefile/cache.mk

first-env:
	composer install
	@make --no-print-directory db-init

init-env:
	@make --no-print-directory db-init

restore-env:
	@make --no-print-directory cache-clear
	@make --no-print-directory db-reset

init-env-test:
	@make --no-print-directory db-init ENV=test

restore-env-test:
	@make --no-print-directory cache-clear
	@make --no-print-directory db-reset ENV=test

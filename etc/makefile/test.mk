test-list-tests:
	@php bin/phpunit --list-tests

test-list-suites:
	@php bin/phpunit --list-suites

test-run-all:
	@php bin/phpunit

test-run-unit:
	@php bin/phpunit --testsuite unit

test-run-integration:
	@php bin/phpunit --testsuite integration

test-run-e2e:
	@php bin/phpunit --testsuite e2e

test-run-auth:
	@php bin/phpunit --testsuite auth

test-run-core:
	@php bin/phpunit --testsuite core

test-run-time-recording:
	@php bin/phpunit --testsuite time-recording

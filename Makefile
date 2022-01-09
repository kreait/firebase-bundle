.DEFAULT_GOAL:= help
.PHONY: tests coverage view-coverage help

tests: vendor ## Executes the test suite
	vendor/bin/phpunit

coverage: vendor ## Executes the test suite and generates code coverage reports
	php -dxdebug.mode=coverage vendor/bin/phpunit -v --coverage-html=build/coverage

view-coverage: ## Shows the code coverage report
	open build/coverage/index.html

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-16s\033[0m %s\n", $$1, $$2}'

.PHONY: $(filter-out vendor,$(MAKECMDGOALS))

help:
	@printf "\033[33mUsage:\033[0m\n  make [target] [arg=\"val\"...]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

qa: composer lint tests cs stan rector-check ## Run all relevant code checks

# See: https://github.com/crossnox/m2r2
changelog: ## Generate changelog file in documentation
	python3 -m venv .Build/changelog
	.Build/changelog/bin/pip install setuptools m2r2
	.Build/changelog/bin/m2r2 CHANGELOG.md && \
	echo ".. _changelog:" | cat - CHANGELOG.rst > /tmp/CHANGELOG.rst && \
	mv /tmp/CHANGELOG.rst Documentation/Changelog/Index.rst && \
	rm CHANGELOG.rst

composer: composer-check composer-norm ## Validate and normalize composer.json

composer-check: ## Validate composer.json
	composer validate

composer-norm: vendor ## Normalize composer.json
	composer normalize

cs: cs-php ## Check and fix coding standards

cs-check: cs-php-check ## Only check coding standards

cs-php: vendor ## Check and fix PHP coding standards
	.Build/bin/ecs check --fix
	.Build/bin/ecs check --fix --config=ecs.docs.php

cs-php-check: vendor ## Only check PHP coding standards
	.Build/bin/ecs check
	.Build/bin/ecs check --config=ecs.docs.php

docs: ## Render documentation
	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation

docs-check: ## Check documentation renders without warnings
	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation --no-progress --fail-on-log

lint: lint-php lint-xlf lint-yaml ## Lint files

lint-php: ## Lint PHP files
	find . -type f -name '*.php' ! -path "./.Build/*" -print0 | xargs -0 -n1 -P4 php -l -n | (! grep -v "No syntax errors detected" )

lint-xlf: ## Lint XLIFF files
	xmllint --schema Resources/Private/Language/xliff-core-1.2-strict.xsd --noout Resources/Private/Language/*.xlf

lint-yaml: vendor ## Lint YAML files
	find -regex '.*\.ya?ml' ! -path "./.Build/*" -exec .Build/bin/yaml-lint -v {} \;

mutation: vendor # Run mutation tests
	XDEBUG_MODE=coverage .Build/bin/infection --min-msi=84 --threads=4 --no-ansi

rector: vendor ## Apply rector rules
	.Build/bin/rector

rector-check: vendor ## Only check against rector rules
	.Build/bin/rector --dry-run

stan: vendor ## Run static analysis
	.Build/bin/phpstan analyse

tests: tests-php ## Run all tests

tests-php: vendor ## Run PHP tests
	.Build/bin/phpunit --configuration=Tests/phpunit.xml.dist

vendor: composer.json $(wildcard composer.lock) ## Install PHP dependencies
	composer install

zip: ## Build ZIP file for upload on extensions.typo3.org
	grep -Po "(?<='version' => ')([0-9]+\.[0-9]+\.[0-9]+)" ext_emconf.php | xargs -I {version} sh -c 'mkdir -p ../zip; git archive -v -o "../zip/$(shell basename $(CURDIR))_{version}.zip" v{version}'

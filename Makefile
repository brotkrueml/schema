.PHONY: qa
qa: cs tests phpstan rector-dry yaml-lint changelog

# See: https://github.com/crossnox/m2r2
.PHONY: changelog
changelog:
	python3 -m venv .Build/changelog
	.Build/changelog/bin/pip install setuptools m2r2
	.Build/changelog/bin/m2r2 CHANGELOG.md && \
	echo ".. _changelog:" | cat - CHANGELOG.rst > /tmp/CHANGELOG.rst && \
	mv /tmp/CHANGELOG.rst Documentation/Changelog/Index.rst && \
	rm CHANGELOG.rst

.PHONY: code-coverage
code-coverage: vendor
	XDEBUG_MODE=coverage .Build/bin/phpunit -c Tests/phpunit.xml.dist --log-junit .Build/logs/phpunit.xml --coverage-text --coverage-clover .Build/logs/clover.xml

.PHONY: cs
cs: vendor
	.Build/bin/ecs --fix
	.Build/bin/ecs --fix --config=ecs.docs.php

.PHONY: docs
docs:
	docker run --rm --pull always -v "$(shell pwd)":/project -t ghcr.io/typo3-documentation/render-guides:latest --config=Documentation

.PHONY: mutation
mutation: vendor
	XDEBUG_MODE=coverage .Build/bin/infection --min-msi=89 --threads=4 --no-ansi

.PHONY: phpstan
phpstan: vendor
	.Build/bin/phpstan analyse

.PHONY: rector
rector: vendor
	.Build/bin/rector

.PHONY: rector-dry
rector-dry: vendor
	.Build/bin/rector --dry-run

.Build/web/typo3conf/ext/schema:
	mkdir -p .Build/web/typo3conf/ext
	ln -s ../../../../. .Build/web/typo3conf/ext/schema

.PHONY: tests
tests: vendor .Build/web/typo3conf/ext/schema
	.Build/bin/phpunit --configuration=Tests/phpunit.xml.dist

vendor: composer.json composer.lock
	composer validate
	composer install
	composer normalize

.PHONY: xlf-lint
xlf-lint:
	xmllint --schema Resources/Private/Language/xliff-core-1.2-strict.xsd --noout Resources/Private/Language/*.xlf

.PHONY: yaml-lint
yaml-lint: vendor
	find -regex '.*\.ya?ml' ! -path "./.Build/*" -exec .Build/bin/yaml-lint --parse-tags -v {} \;

.PHONY: zip
zip:
	grep -Po "(?<='version' => ')([0-9]+\.[0-9]+\.[0-9]+)" ext_emconf.php | xargs -I {version} sh -c 'mkdir -p ../zip; git archive -v -o "../zip/$(shell basename $(CURDIR))_{version}.zip" v{version}'

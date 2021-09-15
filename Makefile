.PHONY: qa
qa: coding-standards tests psalm rector-dry yaml-lint

.PHONY: code-coverage
code-coverage: vendor
	XDEBUG_MODE=coverage .Build/bin/phpunit -c Tests/phpunit.xml.dist --log-junit .Build/logs/phpunit.xml --coverage-text --coverage-clover .Build/logs/clover.xml

.PHONY: coding-standards
coding-standards: vendor
	.Build/bin/php-cs-fixer fix --config=.php_cs --diff

.PHONY: psalm
psalm: vendor
	.Build/bin/psalm

.PHONY: rector
rector: vendor
	.Build/bin/rector

.PHONY: rector-dry
rector-dry: vendor
	.Build/bin/rector --dry-run

.PHONY: tests
tests: vendor
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
	find -regex '.*\.ya?ml' ! -path "./.Build/*" -exec .Build/bin/yaml-lint -v {} \;

.PHONY: zip
zip:
	grep -Po "(?<='version' => ')([0-9]+\.[0-9]+\.[0-9]+)" ext_emconf.php | xargs -I {version} sh -c 'mkdir -p ../zip; git archive -v -o "../zip/$(shell basename $(CURDIR))_{version}.zip" v{version}'

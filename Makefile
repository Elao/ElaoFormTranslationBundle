.PHONY: test

PHP_CS_FIXER_VERSION=v3.10.0

###########
# Helpers #
###########

define message_error
	printf "$(COLOR_ERROR)(╯°□°)╯︵ ┻━┻ $(strip $(1))$(COLOR_RESET)\n"
endef

php8:
	@php -r "exit (PHP_MAJOR_VERSION == 8 ? 0 : 1);" || ($(call message_error, Please use PHP 8) && exit 1)

########
# Lint #
########

lint: lint-phpcsfixer lint-phpstan lint-composer

lint-composer:
	composer validate --strict

php-cs-fixer.phar:
	wget --no-verbose https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/${PHP_CS_FIXER_VERSION}/php-cs-fixer.phar
	chmod +x php-cs-fixer.phar

update-php-cs-fixer.phar:
	rm -f php-cs-fixer.phar
	make php-cs-fixer.phar

lint-phpcsfixer: php8
lint-phpcsfixer: php-cs-fixer.phar
lint-phpcsfixer:
	./php-cs-fixer.phar fix --dry-run --diff

fix-phpcsfixer: php8
fix-phpcsfixer: php-cs-fixer.phar
fix-phpcsfixer:
	./php-cs-fixer.phar fix

lint-phpstan:
	vendor/bin/phpstan analyse --memory-limit=-1

########
# Test #
########

test:
	vendor/bin/simple-phpunit

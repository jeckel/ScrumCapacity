COMPOSER = docker run --rm -it -v `pwd`:/project jeckel/composer:alpine-php7
PHP = docker run --rm -it -v `pwd`:/project -w /project php:7-cli php
CODECEPTION = docker run --rm -it -v `pwd`:/project jeckel/codeception

.PHONY: default install update test

default: install

install:
	$(COMPOSER) install --ignore-platform-reqs

update:
	$(COMPOSER) update --ignore-platform-reqs

test:
	docker-compose run --rm codeception
	#$(CODECEPTION) run --coverage-xml

run:
	docker-compose -d up

stop:
	docker-compose stop

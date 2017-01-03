composer-install:
	@docker run --rm -it -v `pwd`:/project jeckel/composer:latest install

composer-update:
	@docker run --rm -it -v `pwd`:/project jeckel/composer:latest update

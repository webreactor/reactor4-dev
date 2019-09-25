
build: vendor

vendor:
	composer install

docker-run:
	- docker rm -f reactor4-dev
	docker run -d -p 8080:80 -v $(shell pwd):/opt/app -w /opt/app --name reactor4-dev webreactor/nginx-php:v0.0.2
	docker exec reactor4-dev make in-docker-init
	docker logs -f reactor4-dev

in-docker-init:
	rm -rf /var/www
	ln -s /opt/app/htdocs /var/www

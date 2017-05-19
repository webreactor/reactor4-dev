
vendor:
	composer install


docker-run: vendor
	docker run -ti -p 8080:80 -v $(shell pwd):/var/www webreactor/nginx-php-nxlog:v0.0.1


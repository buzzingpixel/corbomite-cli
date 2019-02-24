@echo off

docker exec -it --user root --workdir /app php-corbomite-cli bash -c "php /app/scripts/phpunit"

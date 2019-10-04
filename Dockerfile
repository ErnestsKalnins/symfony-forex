FROM php:7.2-cli

RUN docker-php-ext-install pdo pdo_mysql

COPY . /usr/src/app

WORKDIR /usr/src/app

EXPOSE 8000

CMD ["bin/console", "server:run", "0.0.0.0:8000"]
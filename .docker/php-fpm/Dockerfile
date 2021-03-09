FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libonig-dev \
    curl \
    zip \
    unzip \
    npm

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql
RUN npm i npm@latest -g
RUN npm i yarn -g
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
CMD bash -c "cd /var/www/html && php-fpm"

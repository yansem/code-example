FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

# Создаём группу и пользователя с UID/GID хоста
RUN groupadd -g ${GID} appgroup \
    && useradd -u ${UID} -g appgroup -m -s /bin/bash appuser \
    && mkdir -p /home/appuser/.composer \
    && chown -R appuser:appgroup /home/appuser

# Меняем пользователя в php-fpm (самое важное!)
RUN sed -i "s/user = www-data/user = appuser/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = appgroup/g" /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

COPY . /var/www/html

# Меняем владельца всего проекта на appuser (чтобы artisan и composer работали без root)
RUN chown -R appuser:appgroup /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh \
    && chown appuser:appgroup /usr/local/bin/start.sh

USER appuser

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/start.sh"]

CMD ["php-fpm"]

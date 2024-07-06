FROM dunglas/frankenphp

# Set Caddy server name to "http://" to serve on 80 and not 443
# Read more: https://frankenphp.dev/docs/config/#environment-variables
ENV SERVER_NAME="http://"

RUN apt-get update && apt-get install -y \
    curl \
    libicu-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    librabbitmq-dev \
    libpq-dev \
    supervisor \
    zip \
    unzip \
    && apt-get clean

RUN install-php-extensions \
    gd \
    pcntl \
    opcache \
    pdo \
    pdo_mysql \
    redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy the Laravel application files into the container.
COPY . .

# Start with base PHP config, then add extensions.
COPY ./.docker/php.ini /usr/local/etc/php/
COPY ./.docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Install Laravel dependencies using Composer.
RUN composer install

RUN chown -R www-data:www-data storage bootstrap/cache

# Start Supervisor.
CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/conf.d/supervisord.conf"]

EXPOSE 8089

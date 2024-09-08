# Используем официальный PHP 8.1 образ с расширениями FPM
FROM php:8.1-fpm
# Устанавливаем зависимости для PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Устанавливаем Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Устанавливаем Node.js и npm для работы с фронтендом (если требуется)
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# Копируем содержимое проекта в контейнер
COPY . /var/www

# Устанавливаем рабочую директорию
WORKDIR /var/www

# Устанавливаем права на директории
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Устанавливаем права для директории хранения кэша и логов Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Запуск PHP-FPM
CMD ["php-fpm"]

EXPOSE 9000

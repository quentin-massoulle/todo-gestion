FROM php:8.3-fpm

# Définir le répertoire de travail
WORKDIR /var/www

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libgd-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-external-gd
RUN docker-php-ext-install gd

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Ajouter un utilisateur dédié pour l'application Laravel
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www


# Copier tous les fichiers de l'application dans le conteneur après l'installation des dépendances
COPY . /var/www/

# Attribuer les permissions à l'utilisateur www
RUN chown -R www:www /var/www/

# Copier uniquement les fichiers nécessaires pour utiliser le cache Docker
COPY composer.json composer.lock /var/www/

# Exécuter composer install avec les bonnes permissions
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress && \
    chown -R www:www /var/www/vendor

# Passer à l'utilisateur www
USER www

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Lancer le serveur PHP-FPM
CMD ["php-fpm"]

# cf: https://gist.github.com/Mikulas/449746102591d636640467910eaf8aad
FROM php:7.4-fpm-alpine
MAINTAINER Samuel RODIER

# Force la mise à jour de l'index du géstionnaire de paquets avant de commencer
RUN apk update && rm -rf /var/cache/apk/* && rm -rf /tmp/*

# Installation du module opcache (améliore les performances car utilisé par PHP comme cache de compilation et requis par Symfony)
RUN docker-php-ext-install opcache \
    && docker-php-ext-enable opcache

# Installation du driver Mysql pour PDO (à activer si besoin!)
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# Installation de l'extension intl proposant des fonctionnalités d'internationalisation
RUN apk add --update icu-dev
RUN docker-php-ext-install intl

# Instalation de l'extension zip permettant à PHP de lire et enregistrer des archives au format zip (utilisé par composer)
RUN apk add --no-cache zip libzip-dev \
  && docker-php-ext-install zip

# Supprime des dépendances inutiles
RUN apk del autoconf binutils db expat file g++ gcc gdbm gmp \
  isl libatomic libbz2 libc-dev libffi libgcc libgomp libltdl libmagic libsasl \
  libstdc++ libtool m4 make mpc1 musl-dev perl pkgconf pkgconfig re2c \
  readline sqlite-libs

# Installation d'utilitaire supplémentaires
RUN apk --no-cache add curl bash git

# Installation de composer (gestionnaire de dépendances dans notre projet PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.17

# Tweek quelques paramètres de la config PHP permettant d'upload plus important (upload des cartes d'identités et de la documentation)
RUN touch $PHP_INI_DIR/conf.d/custom-php.ini && \
  echo "post_max_size=70M" >> $PHP_INI_DIR/conf.d/custom-php.ini && \
  echo "upload_max_filesize=64M" >> $PHP_INI_DIR/conf.d/custom-php.ini && \
  echo "max_input_vars=10000" >> $PHP_INI_DIR/conf.d/custom-php.ini && \
  echo "memory_limit=512M" >> $PHP_INI_DIR/conf.d/custom-php.ini && \
  echo "session.gc_maxlifetime=10800" >> $PHP_INI_DIR/conf.d/custom-php.ini
  
# Vide les répertoires de cache et temporaire afin d'avoir une image toute propre !
RUN rm -rf /tmp/* /var/cache/apk/*

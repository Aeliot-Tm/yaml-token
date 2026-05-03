ARG PHP_VERSION=8.2.29
ARG DEBIAN_RELEASE=bookworm

FROM php:${PHP_VERSION}-cli-${DEBIAN_RELEASE}

ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_NO_INTERACTION=1
ARG COMPOSER_VERSION=2.7.6
ARG DEBIAN_FRONTEND=noninteractive
ARG DOCKER_PHP_DEPS='gnupg libxml2-dev libzip-dev python3 yamllint unzip'
ARG XDEBUG_VERSION=3.4.7

RUN set -xe; \
    apt-get --allow-releaseinfo-change update && \
    apt-get install -y -qq ${DOCKER_PHP_DEPS} --no-install-suggests --no-install-recommends && \
    docker-php-ext-install -j$(nproc) xml && \
    docker-php-ext-install -j$(nproc) zip && \
    pecl install xdebug-${XDEBUG_VERSION} && docker-php-ext-enable xdebug

RUN rm -rf /var/lib/apt/lists/* && \
    apt-get clean

# Interactive bash: append history (HISTFILE is set in compose.yaml on the bind-mounted /app).
# Sourced only from ~/.bashrc so login + non-login each load this once (no profile.d / no guard flag).
COPY .infra/docker/php/bash-history.sh /usr/local/etc/yaml-token-bash-history.sh

# Copy php configs
COPY .infra/docker/php/conf.d/*.ini /usr/local/etc/php/conf.d/

RUN printf '\n# yaml-token: persistent shell history (compose HISTFILE on /app).\n[ -r /usr/local/etc/yaml-token-bash-history.sh ] && . /usr/local/etc/yaml-token-bash-history.sh\n' >> /root/.bashrc

# Install composer
RUN set -xe; \
    curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin --version=${COMPOSER_VERSION} > /dev/null 2>&1 && \
    chmod +x /usr/local/bin/composer

# Install PHIVE
RUN set -xe; \
    curl -sSL -o phive.phar https://phar.io/releases/phive.phar && \
    curl -sSL -o phive.phar.asc https://phar.io/releases/phive.phar.asc && \
    gpg --keyserver hkps://keys.openpgp.org --recv-keys 0x9D8A98B29B2D5D79 && \
    gpg --verify phive.phar.asc phive.phar && \
    chmod +x phive.phar && \
    mv phive.phar /usr/local/bin/phive

WORKDIR /app

COPY composer.* ./

RUN set -xe; \
    composer install --no-autoloader --no-dev --no-interaction --no-progress --no-scripts --prefer-dist && \
    composer clear-cache && \
    rm -rf ./vendor/*/*/tests

COPY . ./

RUN composer dump-autoload --optimize

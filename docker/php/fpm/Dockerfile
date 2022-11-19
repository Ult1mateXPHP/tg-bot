FROM php:8.1.6-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
    && sync \
    && install-php-extensions \
    intl \
    pcntl \
    xdebug \
    bcmath \
    amqp \
    pdo_pgsql \
    pdo_mysql \
    sockets \
    redis \
    && apt-get update \
    && apt-get install -y \
       openssl \
       unzip \
       libcurl4-openssl-dev \
       jq \
       curl \
       python3-pip

RUN python3 -m pip install -U yt-dlp
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

COPY ./common "$PHP_INI_DIR/conf.d"

ARG HOST_UID=1000
ARG HOST_GID=1000
ARG HOST_USER=php-app
ARG HOST_GROUP=php-app

# Отключение пароля для sudo
# Добавление пользователя под которым будут входить в контейнер через docker exec
RUN echo '%sudonopswd ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers \
    && groupadd -g $HOST_GID $HOST_GROUP \
    && groupadd sudonopswd \
    && useradd -m -l -g $HOST_GROUP -u $HOST_UID $HOST_USER \
    && usermod -aG sudo $HOST_USER \
    && usermod -aG sudonopswd $HOST_USER \
    && chown -R $HOST_USER:$HOST_GROUP /opt \
    && chmod 755 /opt

# Установка только что созданного пользователя как текущего
USER $HOST_USER

WORKDIR /app

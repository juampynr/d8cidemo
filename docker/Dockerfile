FROM php:7.0-apache

# Change docroot since we use Composer Drupal project
RUN sed -ri -e 's!/var/www/html!/var/www/html/web!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www!/var/www/html/web!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update

# Install composer.
RUN apt-get install -y wget
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/f3333f3bc20ab8334f7f3dada808b8dfbfc46088/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

# Install phantomjs.
RUN apt-get install -y curl bzip2 libfontconfig
RUN cd '/opt' && curl -L https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2 | tar xjvf -
RUN ln -s /opt/phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/local/bin

# Install XDebug.
RUN pecl install xdebug-2.5.5 \
    && docker-php-ext-enable xdebug

# Install Robo CI
RUN wget http://robo.li/robo.phar
RUN chmod +x robo.phar && mv robo.phar /usr/local/bin/robo

# Fixes "Failed to download symfony/yaml from dist: The zip extension and unzip command are both missing, skipping." during composer update.
RUN apt-get install -y zip unzip git

# Install VIM, 'cause it's awesome.
RUN apt-get install -y vim

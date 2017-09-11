FROM drupal:8.3.7-apache

RUN apt-get update

# Install composer.
RUN apt-get install -y wget
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/f3333f3bc20ab8334f7f3dada808b8dfbfc46088/web/installer -O - -q | php -- --quiet
RUN mv composer.phar /usr/local/bin/composer

# Install phantomjs.
RUN apt-get install -y curl bzip2 libfontconfig
RUN cd '/opt' && curl -L https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2 | tar xjvf -
RUN ln -s /opt/phantomjs-2.1.1-linux-x86_64/bin/phantomjs /usr/local/bin

# XDebug.
RUN pecl install xdebug
RUN echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20160303/xdebug.so' > /usr/local/etc/php/conf.d/xdebug.ini

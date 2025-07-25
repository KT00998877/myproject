FROM php:8.2-apache

# Bật rewrite + cho phép .htaccess
RUN a2enmod rewrite
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy toàn bộ mã nguồn vào container
COPY . /var/www/

# Chuyển public thành thư mục chính của Apache
RUN rm -rf /var/www/html && ln -s /var/www/public /var/www/html

# Cài đặt Composer (nếu cần)
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# WORKDIR /var/www
# RUN composer install

EXPOSE 80

FROM php:8.2-apache

# Bật module rewrite của Apache
RUN a2enmod rewrite

# Cho phép sử dụng .htaccess trong /var/www/html
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy mã nguồn vào thư mục web server
COPY public/ /var/www/html/

EXPOSE 80

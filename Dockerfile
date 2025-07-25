FROM php:8.2-apache

# Copy mã vào thư mục web server
COPY public/ /var/www/html/

EXPOSE 80

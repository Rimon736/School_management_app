# Use standard official PHP Apache image
FROM php:8.2-apache

# Copy application source code to the Apache document root
COPY . /var/www/html/

# Enable Apache rewrite module (useful if rewrites are needed later)
RUN a2enmod rewrite

# Expose default HTTP port
EXPOSE 80

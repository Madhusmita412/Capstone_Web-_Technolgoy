# Use official PHP runtime as base image
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    mysql-client \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy project files
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Set environment variables
ENV DB_HOST=db
ENV DB_USER=root
ENV DB_PASS=password
ENV DB_NAME=complaint_system
ENV APP_URL=http://localhost

# Configure Apache
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/docker.conf && \
    a2enconf docker

# Start Apache
CMD ["apache2-foreground"]

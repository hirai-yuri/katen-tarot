# PHPのイメージを指定（例: PHP 8.1-apache）
FROM php:8.1-apache

# 必要な拡張モジュールをインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# サーバーのドキュメントルートを設定
WORKDIR /var/www/html

# 必要なファイルをコンテナにコピー
COPY . /var/www/html/

# Apacheの設定でmod_rewriteを有効にする
RUN a2enmod rewrite

# Dockerfile example to set DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

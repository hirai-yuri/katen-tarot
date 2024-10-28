# PHPのイメージを指定（例: PHP 8.1-apache）
FROM php:8.1-apache

# 必要な拡張モジュールをインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# サーバーのドキュメントルートを設定
WORKDIR /var/www/html

# 必要なファイルをコンテナにコピー
COPY . /var/www/html/

# ファイルの所有者を www-data に変更
RUN chown -R www-data:www-data /var/www/html

# Apacheの設定でmod_rewriteを有効にする
RUN a2enmod rewrite

# DocumentRootの変更とDirectory設定の追加
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>\n    Options Indexes FollowSymLinks\n    AllowOverride All\n    Require all granted\n    DirectoryIndex index.php index.html\n</Directory>' >> /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/storage>\n    Require all denied\n</Directory>' >> /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/config>\n    Require all denied\n</Directory>' >> /etc/apache2/sites-available/000-default.conf

    # ServerNameを設定して警告を抑制
RUN echo "ServerName db" >> /etc/apache2/apache2.conf
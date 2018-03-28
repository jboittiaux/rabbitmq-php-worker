FROM composer:1.6

ENV APP_HOME /app

ENV RABBITMQ_HOST ''
ENV RABBITMQ_PORT ''
ENV RABBITMQ_USER ''
ENV RABBITMQ_PASS ''

RUN docker-php-ext-install bcmath

COPY default-app $APP_HOME
COPY docker-entrypoint.sh /docker-entrypoint.sh

WORKDIR "$APP_HOME"

RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]

EXPOSE 8080

CMD ["php", "index.php"]

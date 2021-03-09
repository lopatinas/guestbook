Для запуска нужны `docker` и `docker-compose`.

После клонирования репозитория выполнить:

     docker-compose up -d

Дождаться запуска и войти в контейнер:

    docker exec -it guestbook_php_1 bash

Выполнить:
        
    /usr/bin/composer install -o --prefer-dist && npm install && yarn install && yarn encore dev

После завершения открыть в браузере http://127.0.0.1:8001/

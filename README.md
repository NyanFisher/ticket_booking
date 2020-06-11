ЗАПУСК ВЕБ-ПРИЛОЖЕНИЯ
---------------------
В терминале выполняем команду:

~~~
    docker-compose up --build -d
~~~

После выполнения команды выполняем другую команду.

~~~
    ./start.sh
~~~

Приложение доступно по адресу:

~~~
    http://127.0.0.1:8000
~~~

API
---
Для доступа к API необходимо иметь access_token, который выдается при регистрации пользователя. И в дальнейшем его можно получить через авторизацию. Его необходимо указывать в заголовках запроса.

### Запросы:
    - 'GET /numbers  => Получить все записи',
    - 'GET /numbers?id={}  => Получить запись по id',
    - 'GET /numbers?page={}  => Получить все записи c пагинацией в 5',
    - 'GET /numbers?status={}  => Получить запись с определенным статусом',
    - 'GET /numbers?page={}&status={}  => Получить записи с пагинацией в 5 и - статусом',
    - 'DELETE /numbers/id  => Удалить запись по id',
    - 'PUT PATCH /numbers/id  => Изменить запись по id',
    - 'POST /numbers  => Создать запись',
    - 'POST /sign-up  => Зарегистрироваться',
    - 'POST /login  => Авторизироваться',
### Параметры в формате JSON:
    **Для регистрации:**
        - "username": строка, не может быть null,
        - "password": строка, не может быть null
    **Для бронирования номеров:**
        - "id": целое число,
        - "datatime_created": строка в формате datetime, не может быть null,
        - "data_arrival": строка в формате date,
        - "status": целое число,
        - "user_id": целое число
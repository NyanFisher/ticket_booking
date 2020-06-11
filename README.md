ЗАПУСК ВЕБ-ПРИЛОЖЕНИЯ
---------------------
В терминале выполняем команду:
    docker-compose up --build -d
После выполнения команды выполняем другую команду.
    ./start.sh

API
---
Для доступа к API необходимо иметь access_token, который выдается при регистрации пользователя. И в дальнейшем его можно получить через авторизацию.
Запросы:
    'GET /numbers  => Получить все записи',
    'GET /numbers?id={}  => Получить запись по id',
    'GET /numbers?page={}  => Получить все записи c пагинацией в 5',
    'GET /numbers?status={}  => Получить запись с определенным статусом',
    'GET /numbers?page={}&status={}  => Получить записи с пагинацией в 5 и статусом',
    'DELETE /numbers/id  => Удалить запись по id',
    'PUT PATCH /numbers/id  => Изменить запись по id',
    'POST /numbers  => Создать запись',
    'POST /sign-up  => Зарегистрироваться',
    'POST /login  => Авторизироваться',
Параметры:
    Для регистрации:
        Формат JSON:
            {
                "username": string, not null,
                "password": string, not null,
            }
    Для бронирования номеров:
    Формат JSON:
            {
                "id": int,
                "datatime_created": string in format datetime, not null,
                "data_arrival": string in format date,
                "status": int,
                "user_id": int,
            }
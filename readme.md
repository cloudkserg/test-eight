## Install

composer install
chmod -R 777 storage
cp .env.example .env

## Settings

Настроить в файле .env параметры подключения к базе данных и к stripe

## Страницы

1) Web

/ - корневая страница со списком товаров
/order/preview - для просмотра страницы
/order/checkout - Для оформления заказа
POST /order/checkout - Для подтверждения заказа через stripe

2) Админка
вход по логину и паролю /admin - список заказов

Создать пользователя можно через консольную комманду
php artisan user:create login password



3) Api

Для доступа используется параметр apiKey (в query)
с ключом, прописанным в .env (параметр APP_API_KEY)

/api/v1/products
POST ap/v1/products = create
PUT api/v1/products/1 = update
GET api/v1/products = index
GET /api/v1/products/1 - show
DELETE api/v1/products/1- delete

Документация через swagger на /doc/
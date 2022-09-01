Step To Use:
------------------------------------------
create database db_name
------------------------------------------
Rename File "env.example" to ".env"
------------------------------------------
fill ".env" to this

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=root
DB_PASSWORD=
------------------------------------------
Run CMD :
------------------------------------------
composer update --no-scripts
------------------------------------------
php artisan key:generate
------------------------------------------
php artisan --serve
------------------------------------------

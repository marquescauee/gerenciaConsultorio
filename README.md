# Gerência Consultório


## Instalação

* PHP >= 8.2
* NPM >= 9.5.1
* Você deve criar um banco de dados com o nome consultorio e alterar as propriedades do .env
* Você deve habilitar pdo_pgsql e memory_limit no php.ini, para achar o php.ini digite:
```sh
php --ini
```

### Depois das configurações, rode os comandos para instalação
```sh
composer update
npm install
php artisan migrate
```
### Para rodar o server
```sh
php artisan serve
```

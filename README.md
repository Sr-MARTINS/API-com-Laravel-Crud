## Requisitos

* PHP 8.2 ou superior
* MySQL 8 ou superior
* Composer

## Como rodar o projeto baixado

Duplicar o arquivo '.env.example' e renomear para '.env'.<br>
Alterar no arquivo .env as credencias do banco de dados.<br>

Instalar as dependencias do PHP
```
composer install
---

Gerar a chave no arquivo .env
```
php artisan key:generate
---

Executar as migration
```
php artinsa migrate
---

Executar as seed
```
php artinsa db:seed
---

Para acessar a API, é recomendado ultilizar o Insomnia para simular requisições á API.
```
http://127.0.0.1:8000/api/users
```



## Sequencia para criar o projeto
Criar o projeto com Laravel.
---

composer create-project laravel/laravel:11 .
---

Alterar no arquivo .env as credenciasis do banco de dados <br>

Criar arquivo de rotas para API
```
php artisan install:api
```
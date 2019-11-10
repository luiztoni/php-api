# Demo web service PHP 7
 
 📖 Conceitos demonstrados:

 * OO Design
 * MVC
 * Front Controller
 * Service Layer
 * Repository Pattern
 * Autorização por token
 * JSON - Serialização e deserialização
 * Conexão PDO  
 * PHP Doc

## Instruções básicas

 1. Instalar e habilitar PHP 7.x com a extensão sqlite PDO  no arquivo php.ini
 2. Iniciar o servidor de desenvolvimento no diretório php-api: *php -S localhost:8080*

### Endpoints:
| Verbo HTTP | URI                     | Descrição            |
| ---------- |:-----------------------:| --------------------:|
| GET        | /products/index         | listar produtos      |
| GET        | /products/show/:id      | mostrar produto      |
| POST       | /products/store         | criar  produto       |
| PUT        | /products/update/:id    | atualizar produto    |
| DELETE     | /products/destroy/:id   | deletar produto      |
| POST       | /users/register         | criar usuário        |
| POST       | /users/login            | autorizar usuário    |
| POST       | /users/logout           | desautorizar usuário |


#### License MIT Copyright (c) 2018 Luiz Toni

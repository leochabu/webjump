O projeto roda sobre PHP >=7.1 e banco de dados MariaDB >=10.4.22
Durante o desevolvimento foi utilizado XAMPP 3.3.0
É necessário habilitar a rewrite_module modules/mod_rewrite.so no httpd.conf no Apache

1. Criar uma base de dados chamada webjump
2. Importar o arquivo webjump.sql para base
3. A partir do root (htdocs, public_html), acessar dashboard.php
4. É necessário cadastrar pelo menos uma categoria antes de cadastrar produtos

O sistema foi criado para se comportar como uma verão mais simples de uma API
Usando Postman, pode exemplo, pode-se realizar requisições
A rota principal é process.php$url=api/<product> <category>
Nas requisições GET, por exemplo process.php$url=api/category/, serão listadas todas as categorias
Nas requisições GET/<id>, por exemplo, api/product/<id> será listado o produto de id=<id> e todas as suas categorias
Todas as requisições respondem com objetos JSON
Para uma requisão PUT ou DELETE é necessário usar o método POST e adicionar um campo _method="PUT/DELETE" ao formulário




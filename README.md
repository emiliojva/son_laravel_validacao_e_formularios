# SON - Laravel Validação e Formulários 

##### COMANDOS INICIAIS

Criar pasta do projeto
> mkdir "src"

Criando projeto laravel pelo composer
>composer create-project --prefer-dist laravel/laravel project_name "5.5.*"

Conectar ao mysql e criar banco
> mysql -uroot -pmysql
> create database son_laravel_form_validation;

Alterar banco de dados no dot .env
>DB_DATABASE=son_laravel_form_validation
 DB_USERNAME=root
 DB_PASSWORD=mysql

Migrar tabelas via php artisan(laravel)
> php artisan migrate

Criar Model com sua respectiva migration
> php artisan make:model Client -m

Se Deletar um arquivo da pasta migration precisa deste comando
> composer dumpautoload
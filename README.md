# SON - Laravel Validação e Formulários 

## Aula 1
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
 

Se Deletar um arquivo da pasta migration precisa deste comando
> composer dumpautoload

## Aula 2 
###### Migração e cliente Pessoa Física

Criar Model com sua respectiva migration Client(tbl clients) e Category(tbl_categories)
> php artisan make:model Client -m

> php artisan make:model Categoria -m

Criar colunas para Migration clients_table.

```
Schema::create('clients', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name'); // nome
    $table->string('document_number'); // modificar o tamanho de cpf/cnpj
    $table->string('email'); // email
    $table->string('phone'); // telefone
    $table->boolean('defaulter'); // inadimplente
    $table->date('date_birth'); // data nascimento
    $table->char('sex',10); // genero
    $table->enum('marital_status', array_keys(\App\Client::MARITAL_STATUS));
    $table->string('phisycal_disability')->nullable(); // deficiencia fisica
    $table->timestamps();
});
```

Migrar novas colunas
> php artisan migrate

## Aula 3 - Model Factory

Documentação
> https://laravel.com/docs/5.5/database-testing#generating-factories

Gera um Factory Pattern na diretorio /database/factories com nome 'ClientFactory'
> php artisan make:factory ClientFactory --model=App\Client

Criterios para fabrição dos modelos de clientes para ClientFactory
Usando lib https://github.com/fzaninotto/Faker/blob/master/readme.md
```
use Faker\Generator as Faker;

// Provedor pt_BR, adiciona funções cpf(), cnpj() e etc.
$faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));


$factory->define(App\Client::class, function (Faker $faker) {
    return [
        //
        'name'=>$faker->name,
        'document_number'=>$faker->cpf(false), // false para nao validar mascara
        'email'=>$faker->unique()->safeEmail,
        'phone'=>$faker->phoneNumber,
        'defaulter'=>array_rand(App\Client::DEFAULTER),
        'date_birth'=>$faker->date(),
        'sex'=> array_rand(App\Client::GENDER),
        'marital_status'=> array_rand( App\Client::MARITAL_STATUS ),
        'physical_disability'=> rand(1,10) % 2 == 0 ? $faker->word : null,
    ];
});
```

#####Acessar tinker para executar/gerar os seguintes comandos:
######Para gerar apenas usa-se o helper factory():
> $cliente = factory(App\Client::class,10)->make(); // 10 active records (collection)
######Para persistir no banco de dados:
> factory(App\Client::class)->create();


## Aula 4 - Seeders

> Semeadores. Recebem dados retornados da Factory e criam um padrao clean test

Criando seeders com conversao de nomes aceitável (gerado para database/seeds/)
>php artisan make:seed ClientsTableSeeder

Dentro de um seeder, usamos o helper factory com o nome da class Model e quantidade de vezes.
Este helper retornar um FactoryBuider que contem o metodo make() e create()
- Make   : Gera instancias do ClassModel
- Create : Persiste no banco
```
/**
 * @var factory Illuminate\Database\Eloquent\FactoryBuilder
 */
factory(App\Client::class,5)->create(); // persiste 5 registros do Model Client conforme factory passada e seus criterios
```

Apos criacao do Seeder e necessario empilha-lo (em /database/seeds/DatabaseSeeder.php), no metodo run():
```
 public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // faz chamada ao ClientsTableSeed em /database/seeds/ atraves do artisan db:seed
        $this->call(ClientsTableSeeder::class);
    }
```

Executando seeder
> php artisan db:seed

Dropando todas as tabelas e refazendo, já com exec do seeder
> php artisan migrate:refresh --seed

> Acessando o tinker novamente, verá os registros iniciais.
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

<br>

---

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

<br>

---

## Aula 3 - Model Factory

Documentação
> https://laravel.com/docs/5.5/database-testing#generating-factories

Gera um Factory Pattern na diretorio /database/factories com nome 'ClientFactory'
> php artisan make:factory ClientFactory --model=App\Client

Criterios para fabrição dos modelos de clientes para ClientFactory
Usando lib https://github.com/fzaninotto/Faker/blob/master/readme.md
```
Class ClientFactory { ... 
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

Acessar tinker para executar/gerar os seguintes comandos:

Para gerar apenas usa-se o helper factory():
> $cliente = factory(App\Client::class,10)->make(); // 10 active records (collection)

Para persistir no banco de dados:
> factory(App\Client::class)->create();

<br>

---

## Aula 4 - Geração de CPFs
```
... complementando codigo acima da classe ClientFactory

// Provedor pt_BR, adiciona funções cpf(), cnpj() e etc.
$faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        (...)
        'document_number'=>$faker->cpf(false), // false para nao validar mascara
        (...)
    ];
});
```

<br>

---

## Aula 5 - Seeders

> Semeadores. Recebem dados retornados da Factory e criam um padrao clean test

Documentação
> https://laravel.com/docs/5.5/seeding#writing-seeders

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

<br>

---

## Aula 6 - Criando rotas em modo resource

> Resource Rotes
São rotas padronizadas para lidar com tarefas de CRUD (Create, Retrieve, Update e Delete).

Documentação
> https://laravel.com/docs/5.5/controllers#resource-controllers

Criando Controllers Resources (Controllers com Rotas para Actions CRUD ), dentro de uma subdiretório
> php artisan make:controller Admin\ClientsController --resource

Classe 'ClientsController' com seu padrao de rotas resources(actions crud). 
```
class ClientsController extends Controller // controller resource
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo "Index ou Listing";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo "GET - Form to Creates one registry";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        echo "POST - Storing Form data Post";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo "GET - Displaying one registry";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        echo "GET - Form loads id {$id} to Update one registry";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        echo "PUT - Updating Form data Post";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        echo "DELETE - Updating Form data Post";
    }
}
```

> Resource Routes 

Formas de Configuração das rotas para Resource

> Usando resource sem grupos de rotas. gera admin/create e etc.
````
/**
 * Declarando rota para recurdo de nome admin.
 * Ex: 'admin/store', 'admin/destroy' e etc.
 */ 
Route::resource('admin','Admin\ClientsController');    
````

> Usando resource com grupos de rotas. gera admin/create e etc.
````
/**
 *  Declarando um resource dentro de um grupo rota. 
 *  admin/[ClientsController@actions]
 */
 Route::group( ['prefix'=>'admin'],function(){
     Route::resource('clients','Admin\ClientsController');        
 });
 ````

> Usando resource com grupos de rotas e namespace. Evita repetição do namespace na frente da string, no parametro de classe

````
/**
 *  Declarando groupo rota verboso(detalhado), com uso do param namespace.
 *  Herdará actions do ClientsController que é um resource route (index,create e outros metodos do padrao)
 */
 Route::group([
     'prefix'    =>'admin',
     'namespace' =>'Admin'
 ],function(){
     Route::resource('clients','ClientsController');
 });
````

## Aula 7 - Resource Index. Listando dados de clientes

> Resource Rote Index
Listagem de dados especificos ao controller in vog

Documentação
> https://laravel.com/docs/5.5/controllers#resource-controllers

> Listing com a action Index() 

codigo para retornar todos os clientes e enviar para o sistema de template engine blade. Boa prática usar a compact para pegar variaveis array|collection
````
    public function index()
    {
        //
        // echo "Index ou Listing";

        $clientsARCollection = \App\Client::all();

        return view('admin.clients.index', compact(['clientsARCollection']));

    }

````

> Exemplo de HTML View padrão no Blade Engine. Localizada no caminho /resources/views/admin/clients/index.blade.php. Por isso o helper view é retornada pela convenção(usando hieraquia com '.' pontos) view("admin.clients.index",[]) , no controler
````
<h3>Listagem de clientes</h3>
<br/><br/>
<table border="1" class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CNPJ/CPF</th>
        <th>Data Nasc.</th>
        <th>E-mail</th>
        <th>Telefone</th>
        <th>Sexo</th>
        <th>Ação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clientsARCollection as $client)
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->document_number }}</td>
            <td>{{ $client->date_birth }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->sex }}</td>
            <td>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
````

## Aula 8 - Blade - Trabalhando com layouts

> Templates/Layouts 
com base no template engine Blade

Documentação
> https://laravel.com/docs/5.5/blade#defining-a-layout

Diretiva @yield - Criador de Seções (sidebar, footer, content e etc...)
> @yield é usada para exibir o conteúdo de uma determinada seção, definida dentro do layout.

Diretiva @section
> @section, como o nome indica, define uma seção do conteúdo. Sendo assim, O valor(html) contido entre a @section('nome_especificado'), será alocado em @yield('nome_especificado')

Extendendo o layout
> usa-se a diretiva @extends('pasta_do_layout/nome_do_layout') para definir qual será o arquivo base que detem a yield('content') na seção apreciada.

Basico de layout.
> Basicamente define-se qual layout será extendido (@extends) e o conteudo para @yield('content') que é feito com @section('content') fazendo wrap do html desejavel.

CSS e JS
> A montagem do layout.blade.php compreende inclusão de css e js, em caminho padrão, dentro de public/css/app.css e /public/js/app.js


## Aula 9 e 10 - Mass Assignment e criação de clientes

Listar Rotas Resources e outras
>php artisan route:list

* Etapas para criar um formulário POST

Adicionar o campo CSRF com função 
> {{ csrf_field }} dentro do form tag

Mass assigment - atribuição em massa 
> $fillable = ['name','document_number', '...'], no model "Client"

Usar a injeção Request $request, do controller, para capturar os dados do POST
> $request->all();

Atribuição segura dos dados com a propriedade $fillable do model. Filtrado pelo fillable
> Client::create( $request->all() );

Redirecionando para listagem ou outro
> return redirect()->to('/admin/clients');

Forçar verificacao de um campo como boolean, tal como checkobox field
>$data['defaulter'] = $request->has('defaulter');


## Aula 11 - Rotas Nomeadas

> Criando uma rota nomeada

````
Route::name('meu-nome')->get('/rota-nomeada',function (){
    echo "Hello Rota nomeada";
});

// OU de outra forma

Route::get('/rota-nomeada',function (){
    echo "Hello Rota nomeada";
})->name('meu-nome');

````

Em Rosource Routes é possivel ver o nome da rota na coluna 'name' do Route:list
> php artisan route:list

Para criar uma ancora pode-se chamar a funcao route para capturar rota por nome
> <a class="btn btn-default" href="{{ route('clients.create') }}">Criar</a>


## Aula 12 - Iniciando com validações de dados

Documentação
> https://laravel.com/docs/5.5/validation

Validacao do PHP com Laravel.

Metodo de Validação do laravel. Se nao atender, retorna para mesma página

```

$this->validate($request, [
    'name'=>'required|max:255', // obrigatorio e no max 255 chars
    'document_number'=> 'required',
    'email'=>'required|email',
    'phone'=>'required',
    'date_birth'=>'required|date',
    'marital_status'=>"required|in:{$maritalStatus}",
    'sex'=>'required|in:m,f',
    'physical_desability'=>'max:255'
]);
```

## Aula 13 - Mostrando erros de validação


Documentação
> https://laravel.com/docs/5.5/validation#working-with-error-messages

Podemos traduzir as mensagens padrao
> em /resources/lang 


> A variavel chamada $errors vem como padrao no blade. Usando o metodo ->all() retorna as mensagens de erros como array(); 

> $errors contem metodos any, all e outros
```
{{--Se houver erros--}}

@if ($errors->any())

 <ul class="alert alert-danger">

     @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
     @endforeach

 </ul>

@endif
```
        
        
## Aula 14 - Página da edição de dados

Capturando dados de com um model ou retornando uma page 404 exception com FindOrFail. 
> Client::findOrFail($id)

Rotas nomeadas com parametros passados (ex id) com função route(). Link para formulario edicao
> <a href="{{ route( 'clients.edit', ['client' => $client->id] ) }}">editar</a>

Formulario de edicao apontando action post para rota nomeada para PUT (gera error)
```
<form method="post" action="{{ route('clients.update' , $clientsAR->id) }}">


```

Method_field para indicar verbo http put, delete e etc
{{-- Associar verbo HTTP PUT com input hidden OU method_field('PUT') --}}
{{-- <input type="hidden" name="_method" value="put"> --}}
{{-- Equivalent method_field('put') --}}
{{  method_field('put') }}

Criar método protegido para fazer validacao tanto na criacao/edicao
```
  protected function _validate(Request $request)
    {
        $maritalStatus = implode( ',' , array_keys(Client::MARITAL_STATUS) );

        // Metodo de Validação do laravel. Se nao atender, retorna para mesma página
        $this->validate($request, [
            'name'=>'required|max:255', // obrigatorio e no max 255 chars
            'document_number'=> 'required',
            'email'=>'required|email',
            'phone'=>'required',
            'date_birth'=>'required|date',
            'marital_status'=>"required|in:{$maritalStatus}",
            'sex'=>'required|in:m,f',
            'physical_desability'=>'max:255'
        ]);

    }
```


Preencher Model Client usando o filtro do fillable
> $clientsAR->fill($data);

Salvar Model com dados do fill()
> $clientsAR->save();

Retornar para pagina usando rota nomeada
> return redirect()->route('clients.index'); //return redirect()->route('/admin/clients');

## Aula 15 - Organização e reaproveitamento de formulários e views

Diretiva @include para incluir controles do formulario(_form.blade.php) no form create e edit
> @include('_form.blade.php'')

Convenção de colocar tratamento de erros( erros->all() e errors->any() ) com include em (forms/form_erros.blade)
> @include('form.form_errors') {{-- Se houver erros --}}


## Aula 16 - Recuperando dados digitados em formularios

Documentação
> https://laravel.com/docs/5.5/requests#old-input

Dados de um post submit da requisicao anterior do usuario, para serem reaproveitados em caso de erro de validação. 

função/helper global old('nome_do_campo') recupera dados do post do usuario 
>old( 'nome_do_campo', valor_do_campo_padrao )


## Aula 17 - Route Model Binding

Ao injetar um ID de modelo em uma ação de rota ou controlador, você frequentemente consulta para recuperar o modelo que corresponde a esse ID. A ligação do modelo de rota do Laravel fornece uma maneira conveniente de injetar automaticamente as instâncias do modelo diretamente em suas rotas. Por exemplo, em vez de injetar o ID de um usuário, você pode injetar a instância inteira do modelo de Usuário que corresponde ao ID fornecido.

documentação
> https://laravel.com/docs/5.8/routing#route-model-binding

Possibita pegar o ID e injetar diretamente no model de ligação no parametro
```
public functionr edit(Client $client)
{
    return view('admin.clients.edit' , compact( [ 'client' ] );
}
```


## Aula 18 - Mostrar dados com modo resource

Criando view para exibir dados do resource show.
> return view('admin.clients.show' , compact(['client']));

## Aula 19 - Modelando no banco de dados tipos de cliente

Criando nova migration para alterar uma tabela e adicionar um tipo(cliente pessoa física ou juridica)
> php artisan make:migration alter_table_to_type_client --table=clients

Criar uma migration para alterar/incluir novo campo em uma tabela, no metodo up() e para desfazer no down()
````
 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
            $table->string('document_number')->unique()->change();
            $table->boolean('defaulter');
            $table->date('date_birth')->nullable()->change();
            $table->char('sex',10)->nullable()->change();
            $table->enum('marital_status',array_keys(\App\Client::MARITAL_STATUS))->nullable()->change();
            $table->string('company_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
            $table->dropUnique('clients_document_number_unique'); //Drop index criado acima - convencao do laravel para criar indexes -> nomedatabela_nomedocampo_unique
            $table->date('date_birth')->change(); // change aplicado sem nullable
            $table->char('sex',10)->change(); // change aplicado sem nullable
            $table->enum('marital_status',array_keys(\App\Client::MARITAL_STATUS))->change(); //change aplicado sem nullable
            $table->dropColumn('company_name'); // dropColumn company criada acima
        });
    }
````

Persistir Migration - gera exception ( Changing columns for table "clients" requires Doctrine DBAL; install "doctrine/dbal".)
> php artisan migrate // Exception lançada por falta da lib doctrine/dbal ao gerar a migração acima

Instalar doctrine/dbal para permitir migrations.  
> composer require doctrine/dbal // CLI

Novo RunException será lançado devido tipo enum nao ser conhecido. 
> Unknown database type enum requested, Doctrine\DBAL\Platforms\MySQL57Platform may not support it.

Registrando a plataforma de suporte ao enum no AppServiceProvider boot();
```
// suporte ao enum
$platform = \Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum','string');
```

Tratando ERROR - "Unknown column type "char" requested."

```
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
            $table->string('document_number')->unique()->change();
            $table->date('date_birth')->nullable()->change();
            $table->string('company_name')->nullable();

            /**
             * Registrar enum manualmente devido a particularidade de banco(sgbd)
             */
            $this->_registrarManualmenteMigrations(); // $table->enum('marital_status',array_keys(\App\Client::MARITAL_STATUS))->nullable()->change(); //            $table->char('sex',10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
            $table->dropUnique('clients_document_number_unique'); //Drop index criado acima - convencao do laravel para criar indexes -> nomedatabela_nomedocampo_unique
            $table->date('date_birth')->change(); // change aplicado sem nullable
            $table->dropColumn('company_name'); // dropColumn company criada acima


            /**
             * DEFAZ manualmente devido a particularidade de banco(sgbd)
             */
            $this->_desfazerManualmenteMigrations();
        });
    }

    **
     * Registra operacaoes de migracao no banco de forma direta ou manual. (sem uso de helper ou dbal package)
     */
    private function _registrarManualmenteMigrations()
    {
        /**
         * alterando campo sexo tipo char aceitando NULL
         */
        \DB::statement('ALTER TABLE clients CHANGE COLUMN sex sex CHAR NULL');

        /**
         * alterando campo estado civil para enum e aceitando NULL
         */
        $maritalStatus = array_keys(\App\Client::MARITAL_STATUS);
        $maritalStatusString = array_map(function($value){
            return "'{$value}'";
        },$maritalStatus);
        $maritalStatusEnum = implode(',' , $maritalStatusString);
        \DB::statement("ALTER TABLE clients CHANGE COLUMN marital_status marital_status ENUM($maritalStatusEnum) NULL");
    }

    /**
     * Desfaz migracoes da funcao 'registrarManualmenteMigrations'
     */
    private function _desfazerManualmenteMigrations()
    {
        \DB::statement('ALTER TABLE clients CHANGE COLUMN sex sex CHAR NOT NULL'); // $table->char('sex',10)->change(); // change aplicado sem nullable
        $maritalStatus = array_keys(\App\Client::MARITAL_STATUS);
        $maritalStatusString = array_map(function($value){
            return "'{$value}'";
        },$maritalStatus);
        $maritalStatusEnum = implode(',' , $maritalStatusString);
        \DB::statement("ALTER TABLE clients CHANGE COLUMN marital_status marital_status ENUM($maritalStatusEnum) NOT NULL"); // $table->enum('marital_status',array_keys(\App\Client::MARITAL_STATUS))->change(); //change aplicado sem nullable
    }
```

efetuar enfim a migração
> php artisan migrate // para up
> php artisan migrate:rollback // para down
> php artisan db:seed // para incluir 5 registros novos



## Aula 20 - Criando campo para separar tipos de clientes (pessoa fisica ou juridica)

Adicionar nova migration para manipular tabela existente
> php artisan make:migration add_client_type_field_to_clients_table --table=clients

Adicionando campo para tipo de cliente(pessoa fisica ou juridica) baseado nas constantes do Model Client 
````
class AddClientTypeFieldToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            /**
             * Adiciona um tipo de pessoa. FISICA(individual)OU JURIDICA(legal)
             */
            $table->string('client_type')->default(\App\Client::TYPE_INDIVIDUAL); // NOT NULL, pessoa física por padrão
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            // remove tipo de pessoa
            $table->dropColumn('client_type'); // remove coluna tipo de pessoa
        });
    }
}
````

Criando constantes no model Client
````
class Client extends Model
{

    const TYPE_INDIVIDUAL = 'individual'; // pessoa física
    const TYPE_LEGAL = 'juridica'; // pessoa juridica
    (...)
}
````


Executando migração
> php artisan migration


## Aula 21 - Seeders com estados de dados

Os estados permitem definir modificações discretas que podem ser aplicadas às fábricas modelo em qualquer combinação. Por exemplo, seu modelo de usuário pode ter um estado delinqüente que modifica um de seus valores de atributo padrão. Você pode definir suas transformações de estado usando o método state. Para estados simples, você pode passar uma matriz de modificações de atributos

Documentação
> https://laravel.com/docs/5.6/database-testing#factory-states

> A chegagem do model em $fillable é desabilitada paras as factories. Portanto ele permite inserir dados







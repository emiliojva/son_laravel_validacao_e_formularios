<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}

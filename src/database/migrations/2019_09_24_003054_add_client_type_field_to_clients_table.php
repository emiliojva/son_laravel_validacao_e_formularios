<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

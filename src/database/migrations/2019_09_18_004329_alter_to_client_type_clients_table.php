<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterToClientTypeClientsTable extends Migration
{
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


    /**
     * Registra operacaoes de migracao no banco de forma direta ou manual. (sem uso de helper ou dbal package)
     */
    private function _registrarManualmenteMigrations(){
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
    private function _desfazerManualmenteMigrations(){
        \DB::statement('ALTER TABLE clients CHANGE COLUMN sex sex CHAR NOT NULL'); // $table->char('sex',10)->change(); // change aplicado sem nullable
        $maritalStatus = array_keys(\App\Client::MARITAL_STATUS);
        $maritalStatusString = array_map(function($value){
            return "'{$value}'";
        },$maritalStatus);
        $maritalStatusEnum = implode(',' , $maritalStatusString);
        \DB::statement("ALTER TABLE clients CHANGE COLUMN marital_status marital_status ENUM($maritalStatusEnum) NOT NULL"); // $table->enum('marital_status',array_keys(\App\Client::MARITAL_STATUS))->change(); //change aplicado sem nullable
    }
}






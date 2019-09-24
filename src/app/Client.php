<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    const TYPE_INDIVIDUAL = 'individual'; // pessoa física
    const TYPE_LEGAL = 'juridica'; // pessoa juridica

    //
    const MARITAL_STATUS = [
        1 => 'Solteiro',
        2 => 'Casado',
        3 => 'Divorciado'
    ]; // status conjugal

    const GENDER = [
        'm'=>'m',
        'f'=>'f'
    ]; // genero/sexo

    const DEFAULTER = [
        0 => 'adimplente',
        1 => 'inadimplente'
    ]; // flag para inadimplentes

    protected $fillable = [
        'name',
        'document_number',
        'email',
        'phone',
        'marital_status',
        'date_birth',
        'sex',
        'physical_disability',
        'defaulter'
    ];
}


/*
$table->increments('id');
$table->string('name'); // nome
$table->string('document_number'); // modificar o tamanho de cpf/cnpj
$table->string('email'); // email
$table->string('phone'); // telefone
$table->boolean('defaulter'); // inadimplente
$table->date('date_birth'); // data nascimento
$table->char('sex',1); // genero
$table->enum('marital_status', array_keys(\App\Client::MARITAL_STATUS));
$table->string('phisycal_disability')->nullable(); // deficiencia fisica
$table->timestamps();
*/
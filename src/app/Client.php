<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
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
}

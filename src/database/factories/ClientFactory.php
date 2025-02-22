<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {

    return [
        //
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'defaulter' => array_rand(App\Client::DEFAULTER),
    ];
});

/**
 *  States - Estado do Factory
 *  Criacao de um estado para pessoa fisica
 * @params Model, valor do estado e callback
 *
 */
$factory->state(\App\Client::class, \App\Client::TYPE_INDIVIDUAL, function (Faker $faker) {

    // Provedor pt_BR, adiciona funções cpf(), cnpj() e etc.
    $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

    return [
        //
        'document_number' => $faker->cpf(false),
        'date_birth' => $faker->date(),
        'sex' => array_rand(App\Client::GENDER),
        'marital_status' => array_rand(App\Client::MARITAL_STATUS),
        'physical_disability' => rand(1, 10) % 2 == 0 ? $faker->word : null,
        'client_type'=>App\Client::TYPE_INDIVIDUAL
    ];

});


/**
 *  States - Estados
 *  Criacao de um estado para pessoa juridica
 * @params Model, valor do estado e callback
 *
 */
$factory->state(\App\Client::class, \App\Client::TYPE_LEGAL, function (Faker $faker) {

    // Provedor Company pt_BR, adiciona funções cnpj() e etc.
    $faker->addProvider(new \Faker\Provider\pt_BR\Company($faker));

    return [
        //
        'document_number' => $faker->cnpj(false),
        'company_name' => $faker->company,
        'client_type'=>App\Client::TYPE_LEGAL
    ];

});

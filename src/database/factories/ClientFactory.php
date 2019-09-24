<?php

use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {

    // Provedor pt_BR, adiciona funções cpf(), cnpj() e etc.
    $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

    return [
        //
        'name' => $faker->name,
        'document_number' => $faker->cpf(false),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'defaulter' => array_rand(App\Client::DEFAULTER),
    ];
});

/**
 *  States - Estados
 * @params Model, valor do estado e callback
 *
 */
$factory->state(\App\Client::class, \App\Client::TYPE_INDIVIDUAL, function (Faker $faker) {

    return [
        //
        'name' => $faker->name,
        'document_number' => $faker->cpf(false),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'defaulter' => array_rand(App\Client::DEFAULTER),
        'date_birth' => $faker->date(),
        'sex' => array_rand(App\Client::GENDER),
        'marital_status' => array_rand(App\Client::MARITAL_STATUS),
        'physical_disability' => rand(1, 10) % 2 == 0 ? $faker->word : null,
    ];

});

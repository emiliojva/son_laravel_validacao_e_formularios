<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // executando um factory via seeder
        /**
         * @var factory Illuminate\Database\Eloquent\FactoryBuilder
         */
        factory(App\Client::class,5)->states(App\Client::TYPE_INDIVIDUAL)->create();
        factory(App\Client::class,5)->states(App\Client::TYPE_LEGAL)->create();
    }
}

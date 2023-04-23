<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Currencies extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Currency::create([
            'name' => 'Peso Argentino',
            'code' => 'ARS',
            'mean' => 90000,
            'buy' => 1.2,
            'sell' => 0.9,
            'emoticon' => '🇦🇷',
            'decimal' => 4,
        ]);

        \App\Models\Currency::create([
            'name' => 'Peso Mexicano',
            'code' => 'MXN',
            'mean' => 4500,
            'emoticon' => '🇲🇽',
        ]);

        \App\Models\Currency::create([
            'name' => 'Peso Chileno',
            'code' => 'CLP',
            'mean' => 22000,
            'emoticon' => '🇨🇱',
            'decimal' => 4,
        ]);

        \App\Models\Currency::create([
            'name' => 'Real',
            'code' => 'BRL',
            'mean' => 1200,
            'buy' => 1.15,
            'sell' => 0.954,
            'emoticon' => '🇧🇷',
        ]);

        \App\Models\Currency::create([
            'name' => 'Bolivar',
            'code' => 'VES',
            'mean' => 8000,
            'emoticon' => '🇻🇪',
        ]);
    }
}

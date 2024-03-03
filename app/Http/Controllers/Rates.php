<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Rates extends Controller
{
    function home()
    {
        $data = \Cache::remember('rates', 3600, function() {
            $binance = new \App\Binance();
            return $binance->rates();
        });

        $currencies = \App\Models\Currency::where('code', '<>', 'VES')->get();

        $paralelo = \Cache::remember('paralelo', 3600, function() {
            return \App\Paralelo::rates();
        });
        return view('home', ['rates' => $data, 'paralelo' => $paralelo, 'currencies' => $currencies]);
    }
}

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

    function image($name)
    {
        $destinationPath = \App\Paralelo::getImage($name);
        if (file_exists($destinationPath)) {
            $cacheDuration = 3600* 24 * 365; // Duración de la caché en segundos, en este caso, 7 días
            $response = response()->file($destinationPath);
            $response->headers->set('Cache-Control', "public, max-age={$cacheDuration}");
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + $cacheDuration) . ' GMT');
            return $response;
        } else {
            abort(404, 'Imagen no encontrada');
        }
    }
}

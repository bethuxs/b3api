<?php
namespace App;

use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class Paralelo
{
    const KEYS = [
        'bcv' => 'BCV',
        'binance' => 'Binance',
        'prom_epv' => 'En Paralelo'
    ];

    static function rates()
    {
        // Crear un cliente Guzzle
        $client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:96.0) Gecko/20100101 Firefox/96.0',
                'Origin' => 'https://monitordolarvenezuela.com',
            ]
        ]);
        $url = 'https://api.monitordolarvenezuela.com/dolarhoy';
        try{
            $response = $client->get($url);
        } catch(\Exception $e) {
            return [];
        }

        // Comprobar si la descarga fue exitosa
        if ($response->getStatusCode() != 200) {
            abort(404);
        }
        $json = json_decode($response->getBody()->getContents());
        if(empty($json->result[0])) {
            return null;
        }
        $result = (array) $json->result[0];

        $r = [];
        foreach($result as $k => $v) {
            if(in_array($k, array_keys(static::KEYS))) {
                $r[static::KEYS[$k]] = $v;
            }
        }
        return $r;
    }
}
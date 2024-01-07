<?php
namespace App;

use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class Paralelo
{
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
        return array_filter($result, function($v, $k) {
            return in_array($k, ['bcv', 'binance', 'prom_epv']);
        }, ARRAY_FILTER_USE_BOTH);
    }

    static function getImage($name)
    {
        return \Cache::remember("img.paralelo.{$name}", 3600*500, function()  use ($name) {
            // Crear un cliente Guzzle
            $client = new Client();

            // URL del archivo que deseas descargar
            $url = "https://monitordolarvenezuela.com/img/{$name}";
            // Ruta donde se guardará el archivo descargado
            $destinationPath = storage_path("app/$name");
            // Realizar la solicitud y guardar el archivo
            $response = $client->get($url, ['sink' => $destinationPath]);
            // Comprobar si la descarga fue exitosa
            if ($response->getStatusCode() != 200) {
                abort(404);
            }
            return $destinationPath;
        });
    }
}
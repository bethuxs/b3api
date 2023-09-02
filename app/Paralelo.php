<?php
namespace App;

use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class Paralelo
{
    static function rates()
    {
        $dom = new Dom;
        $values = $dom->loadFromUrl('https://monitordolarvenezuela.com/')->find('#promedios .col-span-1');
        $data = [];
        foreach ($values as $node) {
            try {
                $img = $node->find('img')->getAttribute('src');
            } catch (\PHPHtmlParser\Exceptions\EmptyCollectionException $e) {
                $img = null;
            }
            $data[] = [
                'name' => $node->find('h3')->text,
                'value' => str_replace(['Bs = '], '', $node->find('p')->text),
                'img' => str_replace('/img/', '', $img),
            ];
        }
        $data = array_map(function ($item) {
            $item['value'] = str_replace(['.', ','], ['', '.'], $item['value']);
            $item['value'] = floatval($item['value']);
            return $item;
        }, $data);

        $data = array_filter($data, function ($item) {
            return $item['value'] > 0;
        });
        return $data;
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
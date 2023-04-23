<?php
namespace App;

use GuzzleHttp\Client;

class Binance
{
    protected $url          = "https://p2p.binance.com";
    protected $endPoint     = "/bapi/c2c/v2/friendly/c2c/adv/search";
    protected $headers      =  [
        'clienttype' => 'android',
        'lang' => 'vi',
        'versioncode' => 14004,
        'versionname' => '1.40.4',
        'BNC-App-Mode' => 'pro',
        'BNC-Time-Zone' => 'Asia/Ho_Chi_Minh',
        'BNC-App-Channel' => 'play',
        'BNC-UUID' => '067042cf79631252f1409a9baf052e1a',
        'referer' => 'https://www.binance.com/',
        'Cache-Control' => 'no-cache, no-store',
        'Content-Type' => 'application/json',
        'Accept-Encoding' => 'gzip, deflate',
        'User-Agent' => 'okhttp/4.9.0'
    ];

    protected $client;

    public function __construct() {
        $this->client = new Client(['verify' => false, 'headers' => $this->headers]);
    }

    public static function mean(array $array)
    {
        $n = count($array); // Obtiene el número de elementos en el array
        if ($n == 0) {
            return 0; // Si no hay elementos, retorna 0
        }

        // Calcula la media (promedio) de los valores en el array
        return (float) array_sum($array) / $n;
    }

    static function desviacionEstandar(array $array) {
        $media = static::mean($array); // Utiliza la función de media proporcionada en la respuesta anterior
        if ($media == 0) {
            return 0; // Si la media es 0, retorna 0
        }
        $n = count($array); // Obtiene el número de elementos en el array

        // Inicializa la suma de las diferencias al cuadrado
        $sumaDiferenciasCuadradas = 0;

        // Itera sobre cada valor del array, calcula la diferencia al cuadrado y acumula en la suma
        foreach ($array as $valor) {
            $diferencia = $valor - $media;
            $sumaDiferenciasCuadradas += pow($diferencia, 2);
        }

        // Calcula la media de las diferencias al cuadrado
        $mediaDiferenciasCuadradas = $sumaDiferenciasCuadradas / $n;

        // Calcula y retorna la raíz cuadrada de la media de las diferencias al cuadrado (desviación estándar)
        return sqrt($mediaDiferenciasCuadradas);
    }

    static function esValorAtipico($valor, array $array) {
        // Calcula la media y la desviación estándar
        $media = static::mean($array);
        $desviacionEstandar = static::desviacionEstandar($array); // Utiliza la función de desviación estándar proporcionada en la respuesta anterior
        $dLimite = 0.5*$desviacionEstandar;
        // Calcula los límites
        $limiteInferior = $media - $dLimite;
        $limiteSuperior = $media + $dLimite;
        // Determina si el valor es atípico
        return $valor < $limiteInferior || $valor > $limiteSuperior;
    }

    public function exchange($asset, $fiat, $tradeType, $amount = 100)
    {
        try {
            $options = [
                'json' => [
                    'asset' => $asset,
                    'tradeType' => $tradeType,
                    'fiat' => $fiat,
                    'transAmount' => $amount,
                    'order' => '',
                    'page' => 1,
                    'rows' => 20,
                    'filterType' => 'all'
                ]
            ];
            $response =  $this->client->request('POST', $this->url.$this->endPoint, $options);
            $data = json_decode($response->getBody());
            $result = [];
            $prices = [];
            foreach ($data->data as $value) {
                $details = array(
                    'price' => $value->adv->price, // price
                    'minSingleTransAmount' => $value->adv->minSingleTransAmount, // min trans amount limit
                    'dynamicMaxSingleTransAmount' => $value->adv->dynamicMaxSingleTransAmount, // max trans amount limit
                    'nickName' => $value->advertiser->nickName,
                );
                $prices[] = (float) $value->adv->price;
                $result[] = $details;
            }
            if(count($prices) == 0) {
                dd($data);
            }

            $all = array_filter($prices, function($price) use ($prices) {
                return !static::esValorAtipico($price, $prices);
            });

            return static::mean($all);
        } catch (RequestException $e) {
            $response = json_decode($e->getResponse()->getBody());
            $this->logger->error($e->getResponse()->getBody());
            return (object)  array(
                'status' => 'error',
                'message' => $response->error->message
            );
        }
    }

    function rates()
    {
        $currencies = \App\Models\Currency::all();
        $info = $currencies->mapWithKeys(function($currency) {
            $key = strtolower($currency->code);
            $type = $currency->code != 'VES' ? 'buy' : 'sell';
            $rate = new \App\Models\Rate();
            $rate->currency_id = $currency->id;
            $rate->rate = $this->exchange('USDT', $currency->code, $type, $currency->mean);
            $rate->save();
            return [
                $key => (object)[
                    'rate' => $rate->rate,
                    'buy' => $currency->buy,
                    'sell' => $currency->sell,
                    'emoticon' => $currency->emoticon,
                    'decimal' => $currency->decimal,
                    'name' => $currency->name,
                ]
            ];
        });

        $ves = $info->pull('ves');
        return $info->map(function($item, $key) use ($ves) {
            $item->rate = $ves->rate / $item->rate;
            return $item;
        });
    }
}

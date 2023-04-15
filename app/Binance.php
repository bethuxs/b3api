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
                $prices[] = $value->adv->price;
                array_push($result, $details);
            }
            if(count($prices) == 0) {
                dd($data);
            }
            return (float) round(array_sum($prices) / count($prices), 2);
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
        return \Cache::remember('binance.rate', 3600, function() {
            $brl = $this->exchange('USDT', 'BRL', 'buy');
            $ves = $this->exchange('USDT', 'VES', 'sell', 5000);
            $ars = $this->exchange('USDT', 'ARS', 'buy', 20000);
            $clp = $this->exchange('USDT', 'CLP', 'buy', 90000);
            $rate = round($ves / $brl, 2);
            $rateAR = round($ves / $ars, 2);
            $rateCL  = round($ves / $clp, 2);
            $rateSale = round(0.95 * $rate, 2);
            $rateBuy = round(1.11 * $rate, 2);
            return compact('brl', 'ves', 'rate', 'ars', 'rateAR',  'rateSale', 'rateBuy', 'rateCL');
        });
    }
}

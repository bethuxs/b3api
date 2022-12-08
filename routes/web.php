<?php

use Illuminate\Support\Facades\Route;
use PHPHtmlParser\Dom;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

function avr(array $data)
{
    asort($data);
    array_pop($data);
    array_pop($data);
    array_shift($data);
    array_shift($data);
    return  array_sum($data) / count($data);
}

function getData($name)
{
    return Cache::remember($name, 6000, function () use ($name) {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://fiis.com.br',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);
        $response = $client->request('GET', "/{$name}");
        return (string) $response->getBody();
    });
}

function parseCurrency($text)
{
    return (float) str_replace(['R$', ' ', ','], ['', '', '.'], $text);
}

$router->get('/', function () use ($router) {
    return 'ok';
});

$router->get('/{name}', function ($name) {
    $body = getData($name);
    $pageDom = new DomDocument();
    $searchPage = mb_convert_encoding($body, 'HTML-ENTITIES', "UTF-8");
    libxml_use_internal_errors(true);
    $pageDom->loadHTML($searchPage, LIBXML_NOWARNING);

    $xpath = new DOMXpath($pageDom);
    $d = collect($xpath->query('//*[@class="flexColumn"]'));
    $data = json_decode($d[0]->getAttribute('data-options'));
    $dividend = collect(current($data->data->items))->map(function ($n){
        return parseCurrency($n->revenue);
    });

    $last = $dividend[0];
    $avr = avr($dividend->toArray());

    $indexes = $xpath->query('//*[@class="indicators__box"]/p/b')->item(3);
    $vpc = parseCurrency($indexes->textContent);

    return response()->json(compact('last', 'avr', 'vpc'));
});

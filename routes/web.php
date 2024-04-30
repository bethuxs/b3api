<?php
use Illuminate\Support\Facades\Route;

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

Route::get('/', '\App\Http\Controllers\Rates@home');

Route::prefix('backoffice')->name('financial.')->middleware('auth')->group(function() {
    Route::get('/spread', '\App\Http\Controllers\Financial@spread')->name('spread');
    Route::post('/spread', '\App\Http\Controllers\Financial@spreadPost')->name('spread-post');
});

Route::prefix('app')->name('app.')->middleware('auth')->group(function() {
    Route::controller(\App\Http\Controllers\Invoices::class)->prefix('invoice')->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/view/{invoice}', 'view')->name('view');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });
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

/*function avr(array $data)
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

*/
$router->get('data/{name}', function ($name) {
    $body = getData($name);
    $pageDom = new DomDocument();
    $searchPage = mb_convert_encoding($body, 'HTML-ENTITIES', "UTF-8");
    libxml_use_internal_errors(true);
    $pageDom->loadHTML($searchPage, LIBXML_NOWARNING);

    $xpath = new DOMXpath($pageDom);
    $d = collect($xpath->query('//*[@class="yieldChart__table__body"]//*[@class="yieldChart__table__bloco"]'));
    $dividend = $d->map(function($e){
        $doc = new DOMDocument();
        $doc->loadXML($e->ownerDocument->saveXML($e));
        $xpath = new DOMXpath($doc);

        return parseCurrency($xpath->query('//*[@class="table__linha"]')->item(4)->textContent);
    });

    $last = $dividend[0];
    $avr = avr($dividend->toArray());

    $indexes = $xpath->query('//*[@class="indicators__box"]/p/b')->item(3);
    $vpc = parseCurrency($indexes->textContent);

    return response()->json(compact('last', 'avr', 'vpc'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

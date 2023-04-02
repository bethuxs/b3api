<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasa de Cambio - Venta: {{$rateSale}} Bs/R$, Compra: {{$rateBuy}} R$/Bs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style type="text/css">
    .pricingTable10{text-align:center}
    .pricingTable10 .pricingTable-header{padding:30px 0;background:#4d4d4d;position:relative;transition:all .3s ease 0s}
    .pricingTable10:hover .pricingTable-header{background:#09b2c6}
    .pricingTable10 .pricingTable-header:after,.pricingTable10 .pricingTable-header:before{content:"";width:16px;height:16px;border-radius:50%;border:1px solid #d9d9d8;position:absolute;bottom:12px}
    .pricingTable10 .pricingTable-header:before{left:40px}
    .pricingTable10 .pricingTable-header:after{right:40px}
    .pricingTable10 .heading{font-size:20px;color:#fff;text-transform:uppercase;letter-spacing:2px;margin-top:0}
    .pricingTable10 .price-value{display:inline-block;position:relative;font-size:55px;font-weight:700;color:#09b1c5;transition:all .3s ease 0s}
    .pricingTable10:hover .price-value{color:#fff}
    .pricingTable10 .month{font-size:16px;color:#fff;position:absolute;bottom:15px;right:-3rem;}
    .pricingTable10 .read{display:inline-block;font-size:16px;color:#fff;text-transform:uppercase;background:#d9d9d8;padding:8px 25px;margin:30px 0;transition:all .3s ease 0s}
    .pricingTable10 .read:hover{text-decoration:none}
    .pricingTable10:hover .read{background:#09b1c5}
    @media screen and (max-width:990px){.pricingTable10{margin-bottom:25px}
    }
    /* Credit to https://bootsnipp.com/snippets/92erW */
    </style>
  </head>
  <body>
    <div class="container">
      <h1 class="text-center m-3">Tasa Bolivares Reales</h1>
      <h3 class="text-center">{{date('d/m/Y')}}</h3>
      <div class="row justify-content-around">
        <div class="col-md-3 col-sm-6">
          <div class="pricingTable10">
            <div class="pricingTable-header">
              <h3 class="heading">A Bolivares</h3>
              <span class="price-value">
                {{$rateSale}}
                <span class="month">Bs/R$</span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="pricingTable10">
            <div class="pricingTable-header">
              <h3 class="heading">A Reales</h3>
              <span class="price-value">
                {{$rateBuy}}
                <span class="month">R$/Bs</span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <h1 class="text-center m-3">Tasa Bolivares Pesos Argetinos</h1>
      <div class="row justify-content-around">
        <div class="col-md-3 col-sm-6">
          <div class="pricingTable10">
            <div class="pricingTable-header">
              <h3 class="heading">A Bolivares</h3>
              <span class="price-value">
                {{$rateAR * 0.9}}
                <span class="month">Bs/$</span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="pricingTable10">
            <div class="pricingTable-header">
              <h3 class="heading">A Pesos</h3>
              <span class="price-value">
                {{$rateAR * 1.2}}
                <span class="month">$/Bs</span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <h1 class="text-center m-3">Tasa Bolivares Pesos Chilenos</h1>
      <div class="row justify-content-around">
        <div class="col-md-3 col-sm-6">
          <div class="pricingTable10">
            <div class="pricingTable-header">
              <h3 class="heading">A Bolivares</h3>
              <span class="price-value">
                {{$rateCL * 0.9}}
                <span class="month">Bs/$</span>
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="pricingTable10">
            <div class="pricingTable-header">
              <h3 class="heading">A Pesos</h3>
              <span class="price-value">
                {{$rateCL * 1.2}}
                <span class="month">$/Bs</span>
              </span>
            </div>
          </div>
        </div>
      </div>


      <h1 class="text-center m-4">Tasa Dolar - Bolivares</h1>
      <div class="row justify-content-around">
        <div class="col-md-3 col-sm-6">
          <div class="pricingTable10">
            <div class="pricingTable-header">
              <h3 class="heading">A Bolivares</h3>
              <span class="price-value">
                {{round($ves*0.97, 2)}}
                <span class="month">$/Bs</span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasa de Cambio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <h1 class="text-center mt-4">Calculadora Para Bolivares</h1>
      <div class="input-group my-3">
        <label class="input-group-text">Tengo</label>
        <input type="number" class="form-control" placeholder="Cantidad" id="inputAmount" />
        <select class="form-control" id="selectCurrency">
          @foreach($rates as $currency => $r)
          <option value="{{$currency}}" data-mult="{{round($r->rate*$r->sell, $r->decimal)}}">{{$r->emoticon}} {{$r->name}}</option>
          @endforeach
        </select>
        <label class="input-group-text col-12 col-sm-3">Recibo&nbsp;<span id="toBs">0</span>&nbsp;Bs</label>
      </div>

      <h1 class="text-center mt-4">Tasa de Cambio</h1>
      <table class="table">
       <thead>
         <tr>
           <th scope="col">Moneda</th>
           <th scope="col">Venta</th>
           <th scope="col">Compra</th>
         </tr>
        </thead>
        <tbody>
          @foreach($rates as $currency => $r)
          <tr>
            <td style="font-size: 20px">{{$r->emoticon}} {{$r->name}}</td>
            <td>{{round($r->rate*$r->sell, $r->decimal)}}</td>
            <td>{{round($r->rate*$r->buy, $r->decimal)}}</td>
          </tr>
          @endforeach
        </tbody>
     </table>

     <h1 class="text-center my-3">Referencias</h1>
     <main class="row justify-content-evenly">
      @foreach($paralelo as $name => $value)
      <article class="col-sm-3 col-lg-2 text-center">
          <h5>{{$name}}</h5>
          <img src="/img/{{$name}}.webp" width="100" height="100" />
          <br />
          Bs. {{number_format((float)$value, 2, ',')}}
      </article>
      @endforeach
    </main>
  </thead>
  <script type="text/javascript">

    function formatCurrency(number, decimals, locale) {
      const factor = Math.pow(10, decimals);
      const roundedNumber = Math.round(number * factor) / factor;

      return roundedNumber.toLocaleString(locale, {
          minimumFractionDigits: decimals,
          maximumFractionDigits: decimals
      });
  }

    document.addEventListener('DOMContentLoaded', function() {
      const input = document.querySelector('#inputAmount');
      const select = document.querySelector('#selectCurrency');
      const toBs = document.querySelector('#toBs');
      const calc = function() {
        const mult = parseFloat(select.options[select.selectedIndex].dataset.mult);
        toBs.innerHTML = formatCurrency(input.value * mult,  2, 'es-ES', 'VES');
      }
      input.addEventListener('keyup', calc);
      input.addEventListener('change', calc);
      select.addEventListener('change', calc);
      calc();
    });
  </script>
  </body>
</html>
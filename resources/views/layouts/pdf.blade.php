<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Financiero')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
      body {
        font-family: 'Nunito', sans-serif;
        padding:0;
        margin: 10px;
        font-size: 14px;
      }
 /* Fila */
        .row {
            display: -webkit-box;
            display: -webkit-flex;
            flex-wrap: wrap;
            -webkit-flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
            box-sizing: border-box;
            width: 100%;
    flex-direction: row;
        }

        /* Columnas */
        [class*="col-"] {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            box-sizing: border-box;
        }

        /* Anchos de columnas */
        .col-1 { -webkit-box-flex: 0; -webkit-flex: 0 0 8.333333%; max-width: 8.333333%; }
        .col-2 { -webkit-box-flex: 0; -webkit-flex: 0 0 16.666667%; max-width: 16.666667%; }
        .col-3 { -webkit-box-flex: 0; -webkit-flex: 0 0 25%; max-width: 25%; }
        .col-4 { -webkit-box-flex: 0; -webkit-flex: 0 0 33.333333%; max-width: 33.333333%; }
        .col-5 { -webkit-box-flex: 0; -webkit-flex: 0 0 41.666667%; max-width: 41.666667%; }
        .col-6 { -webkit-box-flex: 0; -webkit-flex: 0 0 50%; max-width: 50%; }
        .col-7 { -webkit-box-flex: 0; -webkit-flex: 0 0 58.333333%; max-width: 58.333333%; }
        .col-8 { -webkit-box-flex: 0; -webkit-flex: 0 0 66.666667%; max-width: 66.666667%; }
        .col-9 { -webkit-box-flex: 0; -webkit-flex: 0 0 75%; max-width: 75%; }
        .col-10 { -webkit-box-flex: 0; -webkit-flex: 0 0 83.333333%; max-width: 83.333333%; }
        .col-11 { -webkit-box-flex: 0; -webkit-flex: 0 0 91.666667%; max-width: 91.666667%; }
        .col-12 { -webkit-box-flex: 0; -webkit-flex: 0 0 100%; max-width: 100%; }

      table {
  width: 100%;
  table-layout: fixed;
}

h1 {
  font-size: 2.3rem;
}

h4 {
  font-size: 1.3em;
}

h5 {
  font-size: 1.1rem;
}


h6 {
  font-size:0.8rem;
}
    </style>
  </head>
  <body>
    @yield('content')
  </body>
</html>
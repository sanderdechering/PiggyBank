<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Spaarvarken</title>
        {!! MaterializeCSS::include_css() !!}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body class="grey lighten-5">
        <div class="container">
            <div class="row">
                <div class="col s2 offset-s5">
                    <img class="w-75 logo mt-5" src="{{ asset('png/money.png') }}">
                </div>
            </div>
            @yield('content')
        </div>
        {!! MaterializeCSS::include_js() !!}
    </body>
</html>
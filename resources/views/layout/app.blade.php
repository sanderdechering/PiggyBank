<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Spaarvarken</title>
        {!! MaterializeCSS::include_css() !!}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=yn6h1diil7zuwkkijq8o8cql43lmkkh32e11mm7s60v9lbmz"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
    </head>
    <body class="grey lighten-5">
        <div class="container">
            <div class="row">
                <div class="col s2 offset-s5">
                    <img class="w-75 logo mt-3" src="{{ asset('png/money.png') }}">
                </div>
            </div>
            @yield('content')
        </div>
        {!! MaterializeCSS::include_js() !!}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('.datepicker');
                M.Datepicker.init(elems, {format: 'yyyy-mm-dd'});

            });
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('.collapsible');
                var instances = M.Collapsible.init(elems, {});
            });
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('select');
                var instances = M.FormSelect.init(elems, {});
            });
        </script>
    </body>
</html>
<!DOCTYPE html>
<html>
    <head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-gray-300">
        <div id="app">
            <championship
                :matches-data = "{{ json_encode($data) }}"
                route-get-matches-by-parameter = "{{ route('sa.matches.get-matches-by-parameters') }}"
            ></championship>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>

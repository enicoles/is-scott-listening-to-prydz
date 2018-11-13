<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Is Scott Listening to Prydz?</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div class="container">
            <div class="row full-height">
                <div class="col-8 offset-2 align-self-center">
                    <h1 class="text-center">Is Scott Listening to Prydz?</h1>
                    <br>
                    <div id="song-details" class="jumbotron">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

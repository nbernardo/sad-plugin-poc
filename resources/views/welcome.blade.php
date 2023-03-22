<?php
use \App\Http\Controllers\PluginController;
//$mm = new PluginController();
//PluginController::pluginExists("home_main.zip");
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased">
        <div>
            <div>
                @if (PluginController::pluginExists("home_main"))
                    @php
                        PluginController::show("home_main")
                    @endphp
                @endif
            </div>

            <div>
                <form action="/plugin" method="post" enctype="multipart/form-data">
                    @csrf
                    <input name="myFile" type="file"><br/>
                    <button type="submit">Instalar Plugin</button>

                </form>
            </div>
        </div>
    </body>
</html>

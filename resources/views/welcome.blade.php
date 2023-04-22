<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!--==================== UNICONS ====================-->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"/>
        <!--==================== CSS ====================-->

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

       {{-- @vite('resources/css/app.css') --}}
    </head>
    <body>
       <div id="app"></div>
       {{-- @vite('resources/js/app.js') --}}
       <script src="{{ mix('js/app.js') }}" defer></script>

    </body>
</html>

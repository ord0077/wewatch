<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

        <Style>
        @font-face {
    font-family: 'AR';
    /* src: url('./fonts/AR.otf'); */
    src: local('AR'), url('./fonts/AR.otf') format('otf'), url('./fonts/AR.otf') format('truetype');
    /* src: url('./SansationLight.eot');
	src: local('SansationLight'), url('./SansationLight.woff') format('woff'), url('./SansationLight.ttf') format('truetype'); */
}
* {
    font-family:AR;
}
        </style>
    </head>
    <body class=" antialiased" >

        {{-- {{ url('./fonts/AR.otf') }} --}}

        @inertia
    </body>
</html>

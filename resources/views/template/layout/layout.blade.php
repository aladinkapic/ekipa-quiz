<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="bs" > <!-- oncontextmenu="return false" -->
    <head>
        <title> {{ __('Dobrodošli') }} </title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/auth/logo.ico')}}"/>

        <!-- CSS files + fonts -->
        <script src="https://kit.fontawesome.com/cdf2a0a58b.js"></script>
        <link rel="stylesheet" href="{{ asset('css/system.css') }}">

        <!-- JavaScript files -->
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div id="main-div"></div>
        <!-- Import MENU -->
        @include("template.layout.snippets.menu.menu")

        <div class="main-content">
            <!-- Basic header of every page -->
            @include("template.layout.snippets.page-header")

            <!-- Main content of every page -->
            @yield('content')
        </div>
    </body>
</html>

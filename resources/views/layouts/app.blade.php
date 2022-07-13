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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script
            src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous">
        </script>
        @yield('scripts')
    </head>
    <body class="font-sans antialiased" style="position: relative">  
        <div class="min-h-screen bg-gray-100" style="position: relative;">
            <div style="
                    background-image: url({{ asset('images/Monogramma-completo.png') }});
                    background-repeat: no-repeat;
                    background-position: 50% 25%;
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    opacity: 0.3;
                    z-index: -1;
                "></div>
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <!-- usando questo metodo si rende la variabile opzionale e verrà usato solo dove laravel ha costruito le sue pagine -->
                    {{ $header ?? '' }}
                    <!-- con lo yield si usa il metodo normale -->
                    @yield('header')
                    @yield('filter')
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>    
        
    </body>
</html>

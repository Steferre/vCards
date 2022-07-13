<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>


    <style>

        @font-face {
            font-family: 'Futura-Book';
            font-weight: normal;
            font-style: normal;
            src: url('{{ asset('fonts/futura/Futura-Book.otf') }}') format("opentype");
        }
        @font-face {
            font-family: 'Futura-Book';
            font-weight: normal;
            font-style: italic;
            src: url('{{ asset('fonts/futura/Futura-BookOblique.otf') }}') format("opentype");
        }


        @font-face {
            font-family: "futurabookttregular";
            src: url('{{ asset('fonts/futura-web/fonts/FuturaBookTT-Regular.eot')}}');
            src: url('{{ asset('fonts/futura-web/FuturaBookTT-Regular.eot?#iefix')}}') format('embedded-opentype'),
                 url('{{ asset('fonts/futura-web/FuturaBookTT-Regular.woff')}}') format('woff'),
                 url('{{ asset('fonts/futura-web/FuturaBookTT-Regular.ttf')}}') format('truetype'),
                 url('{{ asset('fonts/futura-web/FuturaBookTT-Regular.svg#FuturaBookTT-Regular')}}') format('svg');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: "futurademittregular";
            src: url('{{ asset('fonts/futura-web/futurademic-webfont.eot')}}');
            src: url('{{ asset('fonts/futura-web/futurademic-webfontd41d.eot?#iefix')}}') format('embedded-opentype'),
                 url('{{ asset('fonts/futura-web/futurademic-webfont.woff')}}') format('woff'),
                 url('{{ asset('fonts/futura-web/futurademic-webfont.ttf')}}') format('truetype'),
                 url('{{ asset('fonts/futura-web/futurademic-webfont.svg#futurademittregular')}}') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: "futuralightttregular";
            src: url('{{ asset('fonts/futura-web/futuralightc-webfont.eot')}}');
            src: url('{{ asset('fonts/futura-web/futuralightc-webfontd41d.eot?#iefix')}}') format('embedded-opentype'),
                 url('{{ asset('fonts/futura-web/futuralightc-webfont.woff')}}') format('woff'),
                 url('{{ asset('fonts/futura-web/futuralightc-webfont.ttf')}}') format('truetype'),
                 url('{{ asset('fonts/futura-web/futuralightc-webfont.svg#futuralightttregular')}}') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        .futurabookttregular {
            font-size: 1.2em;
            font-family: "futurabookttregular";
            color: #00626a;
        }
        .futurademittregular {
            font-size: 1.2em;
            font-family: "futurademittregular";
            color: #00626a;
        }
        .futuralightttregular {
            font-size: 1.2em;
            font-family: "futuralightttregular";
            color: #00626a;
        }

        .name {
            font-size: 1.4em;
            font-family: "futurabookttregular";
            color: black;
        }
        .role {
            font-size: 1.2em;
            font-family: "futurabookttregular";
            color: #00626a;
        }

        .team {
            font-size: 1.2em;
            font-family: "futurabookttregular";
            color: #808080;
            font-style: italic
        }

        .company {
            font-size: 1.2em;
            font-family: "futurabookttregular";
            color: #404040;
        }

        .address {
            font-size: 1.2em;
            font-family: "futurabookttregular";
            color: #404040;
        }

        .email {
            font-size: 1.2em;
            font-family: "futurabookttregular";
            color: #00626a;
        }

        .mobile {
            font-size: 1.2em;
            font-family: "futurabookttregular";
            color: #404040;
        }

    </style>


    <title>VCARD</title>
</head>
<body style="margin: 0; padding: 0; box-sizing: border-box;">
    @yield('content')
</body>
</html>
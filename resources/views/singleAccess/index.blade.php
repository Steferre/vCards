<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina singolo accesso con mail</title>
</head>
<body>
    <h1>{{ $message }}</h1>


    <p>{{ $url ?? '' }}</p>
    @if ($url)
        <a href="{{ $url }}">AUTENTICATI</a>
    @else 
        <a href="{{ url()->previous() }}">Torna alla pagina di login</a>
    @endif 
</body>
</html> -->
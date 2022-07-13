<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <title>Area Riservata</title>
</head>
<body>
<div class="mx-auto p-5"> -->
        <!--parte di codice che mostra eventuali errori quando si compila il form di creazione del nuovo promoter-->
        <!-- @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->
        <!-- {{ route('singleAccess.update', ['id' => $promoter->id]) }} -->
        <!-- <form action="{{ route('singleAccess.update', ['id' => $promoter->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @method('PATCH')
            <div class="form-row">
                <div class="form-group col-4">
                    <label for="name">Nome</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" readonly>
                </div>
                <div class="form-group col-4">
                    <label for="email">Email Aziendale</label>
                    <input type="text" name="email" value="{{ $user->email }}" class="form-control" readonly>
                </div>
                <div class="form-group col-4">
                    <label for="email_2">Email Personale</label>
                    <input type="text" name="email_2" value="{{ $promoter->email_2 }}" placeholder="opzionale" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-4">
                    <label for="phone">Cellulare</label>
                    <input type="text" name="mobile" value="{{ $promoter->mobile }}" class="form-control" readonly>
                </div>
                <div class="form-group col-4">
                    <label for="phone_2">Telefono Personale</label>
                    <input type="text" name="phone_2" value="{{ $promoter->phone_2 }}" placeholder="opzionale" class="form-control">
                </div>
                <div class="form-group col-4">
                    <label for="role">Ruolo</label>
                    <input type="text" name="role" value="{{ $promoter->role }}" class="form-control" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-4">
                    <label for="description">Descrizione</label>
                    <textarea name="description" id="description" rows="1" class="form-control"> {{ $promoter->description }}</textarea>
                </div>
                <div class="form-group col-4">
                    <label for="code">Codice</label>
                    <input type="text" name="code" value="{{ $promoter->code }}" class="form-control" readonly>
                </div>
                <div class="form-group col-4">
                    <label for="group">Team</label>
                    <input type="text" name="group" value="{{ $promoter->team }}" class="form-control" readonly>
                </div>
            </div> -->
            <!-- aggiungere input per dare la possibilità di caricare un file -->
            <!-- <div>
                <input type="file" name="file" accept=".pdf">
            </div>
            @if ($promoter->file !== null)
            <div class="mt-3">
                <span class="text-success text-uppercase">file caricato</span>
                 <A HREF="{{url('showcase')}}/{{$promoter->code}}/scheda" title="Scarica la scheda">SCARICA</A> 
                <a href="{{ route('showcase.scheda', $promoter->code) }}" role="button" class="btn btn-info mx-3" title="SCARICA">
                    <i class="bi bi-download"></i>
                </a>
                <a href="{{ route('singleAccess.dropFile', $promoter->id) }}" role="button" class="btn btn-danger" title="CANCELLA">
                    <i class="bi bi-trash"></i>
                </a>
            </div>
            @else
            <div class="mt-3">
                <span class="text-danger text-uppercase">nessun file caricato</span>
            </div>
            @endif
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary mr-2" id="updateBtn">AGGIORNA</button>
                <a href="{{route('singleAccess.logout')}}" class="btn btn-secondary" role="button">LOGOUT</a>
            </div>
        </form>
        <div id="timerBox">
        @if (session('magicmessage'))
            <div class="alert alert-success alert-dismissible fade show" rolw="alert">
                <strong>{{ session('magicmessage') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('magicerror'))
            <div class="alert alert-danger alert-dismissible fade show" id="tdanger" rolw="alert">
                <strong>{{ session('magicerror') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        </div>
    </div>
</body>
</html>
 -->
@extends('layouts.app')
@php
$getParams = $_GET;
$query = null;
if (isset($data['getParams'])) {
    $token = isset($data['getParams']['_token']) ? $data['getParams']['_token'] : null;
    $q_name = $data['getParams']['q_name'];
    $q_code = $data['getParams']['q_code'];
    $q_role = $data['getParams']['q_role'];
    $q_bool = $data['getParams']['q_bool'];
    $page = isset($data['getParams']['page']) ? $data['getParams']['page'] : null;
    $query= '?_token='. $token .'&q_name='.$q_name.'&q_code='.$q_code.'&q_role='.$q_role.'&q_bool='.$q_bool.'&page='.$page;

} else {
    $query;
}

@endphp
@section('header')
    <div class="my-3 py-4 d-flex justify-content-between">
        <a href="{{ route('promoters.index').$query }}" class="btn btn-primary" role="button">Torna alla lista dei promoter</a>
        <a href="{{ route('promoters.edit', ['id' => $promoter->id, 'fullUrl' => Request::fullUrl()]) }}" class="btn btn-primary" role="button">Vai alla modifica</a>
    </div>
@stop
@section('content')
    <h1 class="text-center mb-5">Scheda promotore</h1>
    <div class="container">
        <div class="row">
            <div class="col-4">Codice: <strong>{{ $promoter->code }}</strong> (<strong><i>{{ $promoter->active ? 'Attivo' : 'Non attivo' }}</i></strong>)</div>
            <div class="col-4">Azienda: <strong>{{ $promoter->company }}</strong></div>
            <div class="col-4"></div>
        </div>

        <div class="row mt-2">
            <div class="col-4">Nominativo: <strong>{{ $user->name }}</strong></div>
            <div class="col-4">Email: <strong>{{ $user->email }}</strong></div>
            <div class="col-4">Cellulare: <strong>+39 {{ $promoter->mobile }}</strong></div>
        </div>

        <div class="row mt-2">
            <div class="col-4">Area: <strong>{{ $promoter->area }}</strong></div>
            <div class="col-4">Ruolo: <strong>{{ $promoter->role }}</strong></div>
            <div class="col-4">Team: <strong>{{ $promoter->team }}</strong></div>
        </div>

        <div class="row mt-3">
            <div class="col-4">Telefono 1:
                @if($promoter->phone1)
                    <strong>+39 {{ $promoter->phone1 }}</strong>
                @endif
            </div>
            <div class="col-8">Indirizzo 1: <strong>{{ $promoter->addr1 }}</strong> - <strong>{{ $promoter->cap1 }}</strong> <strong>{{ $promoter->city1 }}</strong> (<strong>{{ $promoter->prov1 }}</strong>)</div>
        </div>

        @if($promoter->addr2 || $promoter->phone2 )
            <div class="row mt-2">
                <div class="col-4">Telefono 2:
                    @if($promoter->phone2)
                        <strong>+39 {{ $promoter->phone2 }}</strong>
                    @endif
                </div>
                @if($promoter->addr2)
                    <div class="col-8">Indirizzo 2: <strong>{{ $promoter->addr2 }}</strong> - <strong>{{ $promoter->cap2 }}</strong> <strong>{{ $promoter->city2 }}</strong> (<strong>{{ $promoter->prov2 }}</strong>)</div>
                @endif
            </div>
        @endif

        @if($promoter->addr3 || $promoter->phone3 )
            <div class="row mt-2">
                <div class="col-4">Telefono 3:
                    @if($promoter->phone3)
                        <strong>+39 {{ $promoter->phone3 }}</strong>
                    @endif
                </div>
                @if($promoter->addr3)
                    <div class="col-8">Indirizzo 3: <strong>{{ $promoter->addr3 }}</strong> - <strong>{{ $promoter->cap3 }}</strong> <strong>{{ $promoter->city3 }}</strong> (<strong>{{ $promoter->prov3 }}</strong>)</div>
                @endif
            </div>
        @endif

        @if($promoter->website)
            <div class="text-left mt-3">Sito web: <strong>{{ $promoter->website }}</strong></div>
        @endif

        @if($promoter->description)
            <div class="text-left mt-3">Descrizione: <strong>{{ $promoter->description }}</strong></div>
        @endif

        <div class="row mt-4">
            <div class="col-sm-4">
                <h6><strong>Immagine</strong></h6>
                @if($fotopath !== null)
                    <img src="{{ asset('storage/'.$fotopath) }}" height="128" alt="Foto del promotore" title="Foto del promotore" />
                @else
                    <span class="text-danger">Non presente</span>
                @endif
            </div>
            <div class="col-sm-4 offset-4">
                <h6><strong>Firma</strong></h6>
                @if($firmapath !== null)
                    <img src="{{ asset('storage/'.$firmapath) }}" height="128" alt="Firma del promotore" title="Firma del promotore" />
                @else
                    <span class="text-danger">Non presente</span>
                @endif
            </div>
        </div>
    </div>
@stop


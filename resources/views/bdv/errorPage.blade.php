@extends('layouts.bdvPromoter')

@section('content')
<div style="background-image: url({{asset('images/Monogramma.png')}}); background-repeat: no-repeat; background-position: left bottom; padding-bottom: 80px; width: 100%; height: 100vh" class="container pt-3">
    <div class="row" style="height: 70vh;">
        <div class="col-12 align-self-start">
            <img src="{{ asset('images/Logo_AZ_WM.png') }}" alt="logo Azimut Wealth Management">
        </div>
        <div class="col-10 offset-1 align-self-center">
            <h3 class="mobile" style="font-size: 35px; font-style: italic;">Siamo spiacenti ma il promoter selezionato non è al momento disponibile!</h3>
        </div>
        <div class="col-10 offset-2 align-self-end">
            <img src="{{ asset('images/Oltre-Privilegio.png') }}" alt="motto aziendale logo" style="width: 100%; max-width: 332px;">
        </div>
    </div>
</div>
@stop
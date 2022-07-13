@extends('layouts.bdvPromoter')

@section('content')
<div style="background-image: url({{asset('images/Monogramma.png')}}); background-repeat: no-repeat; background-position: left bottom; padding-bottom: 80px;" class="container pt-3">
    <div class="row">
        <div class="col">
            <img src="{{ asset('images/Logo_AZ_WM.png') }}" alt="logo Azimut Wealth Management">
        </div>
    </div>
    <div class="row ml-1" style="margin-top: 24px">
        <div class="col-12 name">{{ $user->name}}</div>
        @if($promoter->role)
            <div class="col-12 role">{{ $promoter->role }}</div>
        @endif
        @if($promoter->team)
            <div class="col-12 team">{{ $promoter->team }}</div>
        @endif
        @if($promoter->company)
            <div class="col-12 mt-3 company">{{ $promoter->company }}</div>
        @endif
    </div>

    <div class="row mt-2 ml-1">
        <div class="col-12 address">{{ $promoter->cap1 }} {{ $promoter->city1 }} ({{ $promoter->prov1 }})</div>
        <div class="col-12 address">{{ $promoter->addr1 }}</div>
        @if($promoter->phone1)
            <div class="col-12 address">T +39 {{ $promoter->phone1 }}</div>
        @endif

    </div>

    @if($promoter->addr2)
        <div class="row mt-2 ml-1">
            <div class="col-12 address">{{ $promoter->cap2 }} {{ $promoter->city2 }} ({{ $promoter->prov2 }})</div>
            <div class="col-12 address">{{ $promoter->addr2 }}</div>
            @if($promoter->phone2)
                <div class="col-12 address">T +39 {{ $promoter->phone2 }}</div>
            @endif
        </div>
    @endif

    @if($promoter->addr3)
        <div class="row mt-2 ml-1">
            <div class="col-12 address">{{ $promoter->cap3 }} {{ $promoter->city3 }} ({{ $promoter->prov3 }})</div>
            <div class="col-12 address">{{ $promoter->addr3 }}</div>
            @if($promoter->phone3)
                <div class="col-12 address">T +39 {{ $promoter->phone3 }}</div>
            @endif
        </div>
    @endif
        <div class="row mt-2 ml-1">
        <div class="col-12 mobile">M +39 {{ $promoter->mobile }}</div>
    </div>

    <div class="row ml-1">
        <div class="col-12 email">{{ $user->email }}</div>
    </div>

    @if($promoter->website)
        <div class="row ml-1">
            <div class="col-12 email">{{ $promoter->website }}</div>
        </div>
    @endif

    <!--sezione logo-->
    <div class="row">
        <div class="col-10 offset-2 d-flex">
            <img src="{{ asset('images/Oltre-Privilegio.png') }}" alt="motto aziendale logo" style="width: 100%; max-width: 332px;">
        </div>
    </div>
    <!--sezione bottoni salvataggio e download pdf-->
    <div class="row">
        <div class="col-10 offset-2 d-flex justify-content-end mt-3">
            <a href="{{ route('bdv.vcard', $promoter->code) }}">
                <img src="{{ asset('images/vcard_button.png') }}"alt="Scarica vCard" title="Scarica vCard" style="width: 100%; max-width: 227px;" />
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-10 offset-2 d-flex justify-content-end mt-1 mb-4">
            <a href="{{ route('bdv.pdf', $promoter->code) }}">
                <img src="{{ asset('images/pdf_button_modificato_2.png') }} " alt="Scarica la scheda" title="Scarica la scheda" style="width: 100%; max-width: 227px;" />
            </a>
        </div>
    </div>
</div>
@stop
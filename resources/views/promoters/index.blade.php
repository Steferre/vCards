@extends('layouts.app')
@php
$getParams = $_GET;
@endphp
@section('scripts')
<script type="text/javascript">
   $(document).ready(function () {
        console.log('ready');
        const route = '{{ route("promoters.disable", 0) }}';

        $('[id^="btn_enable_"]').on('click', function() {
            const id = $(this).data('promoter-id');
            const status = $(this).data('promoter-status');
            if(!id) return;
            if(typeof status === "undefined") return;

            const userChoise = confirm('vuoi continuare?');

            if(userChoise) {
                $('#promoter_id').val(id);
                $('#promoter_status').val(status);

                $('#change_status').attr('action', route.replace('/0', '/'+id));

                $('#change_status').submit();
            }
        });
    });
</script>
@stop
@section('header')
    <div class="mx-4 py-3">
        <a href="{{ route('promoters.create') }}" class="btn btn-primary">Nuovo Promotore</a>
    </div>
@stop


@section('filter')
    <!--tramite questo form procediamo a filtrare i dati in base al nome-->
    <div class="mx-4 py-3 d-flex justify-content-between">
        <form action="{{ route('promoters.index') }}" method="GET">
            @csrf
            <div class="form-row align-items-center">
                <div class="col-auto">
                    <input type="text" name="q_name" class="form-control" placeholder="Filtra per nominativo" value="{{ $name ?? '' }}">
                </div>
                <div class="col-auto">
                    <input type="text" name="q_code" class="form-control" placeholder="Filtra per codice" value="{{ $code ?? '' }}">
                </div>
                <div class="col-auto">
                    <input type="text" name="q_role" class="form-control" placeholder="Filtra per ruolo" value="{{ $role ?? '' }}">
                </div>
                <div class="col-auto">
                    <select name="q_bool" class="form-control">
                        <option <?php if (isset($bool) && $bool=="") echo "selected";?> value="">-- Attivo/Sospeso --</option>
                        <option <?php if (isset($bool) && $bool==0) echo "selected";?> value="0">Sospeso</option>
                        <option <?php if (isset($bool) && $bool==1) echo "selected";?> value="1">Attivo</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">CERCA</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('promoters.index') }}" class="btn btn-secondary" role="button">ANNULLA FILTRI</a>
                </div>
            </div>
        </form>
        <!--form per l'export dei dati-->
        <form action="{{ route('promoters.export') }}" method="GET">
            @csrf
            <input type="hidden" name="q_name" value="{{ $name ?? '' }}">
            <input type="hidden" name="q_role" value="{{ $role ?? '' }}">
            <input type="hidden" name="q_bool" value="{{ $bool ?? '' }}">
            <button type="submit" class="btn btn-info">Scarica dati</button>
        </form>
    </div>
@stop

@section('content')
    <div class="mx-5 py-3">
        <table class="table table-sm table-hover table-borderless">
            <caption style="caption-side: top;">Elenco Promotori</caption>
            <thead class="thead-dark">
                <tr>
                    <th>NOME</th>
                    <th>EMAIL</th>
                    <th>CELLULARE</th>
                    <th>RUOLO</th>
                    <th>CODICE</th>
                    <th>AREA</th>
                    <th>TEAM</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($promoters as $promoter)
                    @if($promoter->active === 1)
                    <tr>
                        @else
                    <tr style="color: red;">
                    @endif
                        <td>{{ $promoter->name }}</td>
                        <td>{{ $promoter->email }}</td>
                        <td>+39 {{ $promoter->mobile}}</td>
                        <td>{{ $promoter->role }}</td>
                        <td>{{ $promoter->code }}</td>
                        <td>{{ $promoter->area }}</td>
                        <td>{{ $promoter->team }}</td>

                        <td>
                            <a title="Mostra dettagli" class="mr-2" href="{{ route('promoters.show', ['id' => $promoter->id, 'getParams' => $getParams]) }}">
                                <i class="bi bi-search"></i>
                            </a>
                            <a title="Modifica" class="mr-2" href="{{ route('promoters.edit', ['id' => $promoter->id, 'fullUrl' => Request::fullUrl()]) }}">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            @if ($promoter->active == 1)
                            <button class="mr-2" id="btn_enable_{{ $promoter->id }}" data-promoter-id="{{ $promoter->id }}" data-promoter-status="0" style="border: none; background-color: transparent;" title="Sospendi">
                                <i class="bi bi-lock-fill" style="color: red;"></i>
                            </button>
                            @else
                            <button class="mr-2" id="btn_enable_{{ $promoter->id }}" data-promoter-id="{{ $promoter->id }}" data-promoter-status="1" style="border: none; background-color: transparent;" title="Abilita">
                                <i class="bi bi-unlock-fill" style="color: green;"></i>
                            </button>
                            @endif
                            <a title="Visualizza anteprima" class="mr-2" href="{{ route('bdv.show', $promoter->code) }}">
                                <i class="bi bi-person-square"></i>
                            </a>
                            <a title="Scarica vCard" href="{{ route('bdv.vcard', $promoter->code) }}">
                                <i class="bi bi-card-text"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $promoters->appends(['q_name' =>  $name ?? "", 'q_code' =>  $code ?? "", 'q_role' =>  $role ?? "", 'q_bool' =>  $bool ?? ""  ])->links() }}

        <form method="POST" id="change_status" name="change_status">
            @csrf
            @method('PATCH')
            <input type="hidden" id="promoter_status"  name="active"  />
        </form>
    </div>
@stop

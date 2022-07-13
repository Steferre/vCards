@extends('layouts.app')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $( "#pictureInput" ).change(function() {
                console.log('picture');
                $('#pictureInputButton').hide();
                const fileObj = $('#pictureInput')[0].files[0];

                $('#pictureSelectedFile').html('Nuovo file: ' + fileObj.name);
                $('#pictureSelectedFile').show();
            });

            $( "#signatureInput" ).change(function() {
                $('#signatureInputButton').hide();
                const fileObj = $('#signatureInput')[0].files[0];
                $('#signatureSelectedFile').html('Nuovo file: ' + fileObj.name);
                $('#signatureSelectedFile').show();
            });

            $("#myBtnHide1").click(function() {
                $("#box1").hide();
                $("#myBtnHide1").css("display", "none");
                $("#myBtnShow1").css("display", "inline-block");
            });
            $("#myBtnShow1").click(function() {
                $("#box1").show();
                $("#myBtnHide1").css("display", "inline-block");
                $("#myBtnShow1").css("display", "none");
            });

            $("#myBtnHide2").click(function() {
                $("#box2").hide();
                $("#myBtnHide2").css("display", "none");
                $("#myBtnShow2").css("display", "inline-block");
            });
            $("#myBtnShow2").click(function() {
                $("#box2").show();
                $("#myBtnHide2").css("display", "inline-block");
                $("#myBtnShow2").css("display", "none");
            });

            $("#myBtnHide3").click(function() {
                $("#box3").hide();
                $("#myBtnHide3").css("display", "none");
                $("#myBtnShow3").css("display", "inline-block");
            });
            $("#myBtnShow3").click(function() {
                $("#box3").show();
                $("#myBtnHide3").css("display", "inline-block");
                $("#myBtnShow3").css("display", "none");
            });
        });
    </script>
@stop

@section('header')
    <h1 class="pb-2">Aggiunta nuovo promoter</h1>
    <div class="mt-3 pb-4">
        <a href="{{ route('promoters.index') }}" class="btn btn-primary">Annulla inserimento</a>
    </div>
@stop

@section('content')
    <div class="mx-auto p-5">
        <!--parte di codice che mostra eventuali errori quando si compila il form di creazione del nuovo promoter-->
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('promoters.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-2">
                    <label for="name">Nome</label>
                    <input type="text" name="firstname" value="{{ old('firstname') }}" class="form-control">
                </div>

                <div class="form-group col-2">
                    <label for="name">Cognome</label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control">
                </div>

                <div class="form-group col-2">
                    <label for="code">Codice</label>
                    <input type="text" name="code" value="{{ old('code') }}" class="form-control">
                </div>

                <div class="form-group col-3">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                </div>

                <div class="form-group col-3">
                    <label for="mobile">Cellulare</label>
                    <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-3">
                    <label for="company">Azienda</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="form-control">
                </div>

                <div class="form-group col-2">
                    <label for="area">Area</label>
                    <input type="text" name="area" value="{{ old('area') }}" class="form-control">
                </div>
                
                <div class="form-group col-2">
                    <label for="role">Ruolo</label>
                    <input type="text" name="role" value="{{ old('role') }}" class="form-control">
                </div>

                <div class="form-group col-2">
                    <label for="group">Team</label>
                    <input type="text" name="team" value="{{ old('team') }}" class="form-control" placeholder="opzionale">
                </div>

                <div class="form-group col-3">
                    <label for="website">Sito Web</label>
                    <input name="website" id="website" type="text" class="form-control" value="{{ old('website') }}" placeholder="opzionale"/>
                </div>

                <div class="form-group col-3">
                    <label for="extralogo">Logo</label>
                    <select name="extralogo" id="extralogo" class="form-control">
                        <option value="none">Scegli il logo..(default Nessuno)</option>
                        <option value="none">Nessuno</option>
                        <option value="efpa">Logo EFPA</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row" style="display: none;">
                <div class="form-group col-12">
                    <label for="description">Descrizione</label>
                    <textarea name="description" id="description" rows="1" placeholder="opzionale" class="form-control">{{ old('description') }}</textarea>
                </div>
            </div>
            <!--inizio sezione indirizzi-->
            <!--indirizzo-->
            <div class="form-row mb-3">
                <span class="mr-2">SEZIONE INDIRIZZO 1</span>
                <span class="mr-2" id="myBtnShow1" style="display: none" title="MOSTRA">
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <span id="myBtnHide1" title="NASCONDI">
                    <i class="bi bi-caret-up-fill"></i>
                </span>
            </div>
            <div id="box1" class="border rounded p-3">
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="addr1">Via/Piazza</label>
                        <input type="text" class="form-control" name="addr1" value="{{ old('addr1') }}">
                    </div>
                    <div class="form-group col-4">
                        <label for="city1">Città</label>
                        <input type="text" class="form-control" name="city1" value="{{ old('city1') }}">
                    </div>
                    <div class="form-group col-4">
                        <label for="prov1">Provincia</label>
                        <input type="text" class="form-control" name="prov1" value="{{ old('prov1') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="cap1">Cap</label>
                        <input type="text" class="form-control" name="cap1" value="{{ old('cap1') }}">
                    </div>
                    <div class="form-group col-4">
                        <label for="phone1">Telefono</label>
                        <input type="text" class="form-control" name="phone1" value="{{ old('phone1') }}" placeholder="opzionale">
                    </div>
                </div>
            </div>
            <!--indirizzo 2-->
            <div class="form-row my-3">
                <span class="mr-2">SEZIONE INDIRIZZO 2</span>
                <span class="mr-2" id="myBtnShow2" title="MOSTRA">
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <span id="myBtnHide2" style="display: none" title="NASCONDI">
                    <i class="bi bi-caret-up-fill"></i>
                </span>
            </div>
            <div id="box2" style="display: none;" class="border rounded p-3">
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="addr2">Via/Piazza</label>
                        <input type="text" class="form-control" name="addr2" value="{{ old('addr2') }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="city2">Città</label>
                        <input type="text" class="form-control" name="city2" value="{{ old('city2') }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="prov2">Provincia</label>
                        <input type="text" class="form-control" name="prov2" value="{{ old('prov2') }}" placeholder="opzionale">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="cap2">Cap</label>
                        <input type="text" class="form-control" name="cap2" value="{{ old('cap2') }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="phone2">Telefono</label>
                        <input type="text" class="form-control" name="phone2" value="{{ old('phone2') }}" placeholder="opzionale">
                    </div>
                </div>
            </div>
            <!--indirizzo 3-->
            <div class="form-row my-3">
                <span class="mr-2">SEZIONE INDIRIZZO 3</span>
                <span class="mr-2" id="myBtnShow3" title="MOSTRA">
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <span id="myBtnHide3" style="display: none" title="NASCONDI">
                    <i class="bi bi-caret-up-fill"></i>
                </span>
            </div>
            <div id="box3" style="display: none;" class="border rounded p-3">
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="addr3">Via/Piazza</label>
                        <input type="text" class="form-control" name="addr3" value="{{ old('addr3') }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="city3">Città</label>
                        <input type="text" class="form-control" name="city3" value="{{ old('city3') }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="prov3">Provincia</label>
                        <input type="text" class="form-control" name="prov3" value="{{ old('prov3') }}" placeholder="opzionale">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="cap3">Cap</label>
                        <input type="text" class="form-control" name="cap3" value="{{ old('cap3') }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="phone3">Telefono</label>
                        <input type="text" class="form-control" name="phone3" value="{{ old('phone3') }}" placeholder="opzionale">
                    </div>
                </div>
            </div>
            <!--fine sezione indirizzi-->

            <div class="form-row">
                <!-- inizio stato promoter-->
                <div class="form-group col-2">
                    <label for="active">Stato:</label>
                    <div class="form-check">
                        <input type="radio" name="active" value=1 class="form-check-input">
                        <label for="active" class="form-check-label">Attivo</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="active" value=0 class="form-check-input">
                        <label for="active" class="form-check-label">Sospeso</label>
                    </div>
                </div>
                <!-- fine stato promoter-->

                <!-- sezione aggiunta foto e firma-->
                <!-- sezione foto -->
                <div class="form-group col-5">
                    <label for="pictureInput">Immagine</label>
                    <label id="pictureInputButton" for="pictureInput" style="cursor:pointer" >
                        <i class="bi bi-plus-circle" style="color: green;"></i>
                    </label>
                    <input type="file" id="pictureInput" name="pictureInput" accept=".jpg"
                            style="display: none; border: none; background-color: transparent;" title="Aggiungi" />

                    <span id="pictureSelectedFile" style="display: none; font-weight: bold; color: #3490dc"></span>
                    <input type="hidden" id="pictureAction" name="pictureAction" value="none" class="form-control">
                </div>
                <!-- sezione firma -->
                <div class="form-group col-5">
                    <label for="name">Firma</label>

                    <label id="signatureInputButton" for="signatureInput" style="cursor:pointer" >
                        <i class="bi bi-plus-circle" style="color: green;"></i>
                    </label>
                    <input type="file" id="signatureInput" name="signatureInput" accept=".jpg"
                            style="display: none; border: none; background-color: transparent;" title="Aggiungi" />
                    <span id="signatureSelectedFile" style="display: none; font-weight: bold; color: #3490dc"></span>

                    <input type="hidden" id="signatureAction" name="signatureAction" value="none" class="form-control">
                </div>
            </div>

            <!-- bottone invio form -->
            <div class="form-group py-5">
                <button type="submit" class="float-right btn btn-primary mt-2">INSERISCI</button>
            </div>
        </form>
    </div>
@stop

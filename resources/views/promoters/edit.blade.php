@extends('layouts.app')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $( "#pictureInput" ).change(function() {
                $('#pictureInputButton').hide();
                const fileObj = $('#pictureInput')[0].files[0];
                $('#pictureSelectedFile').html('Nuovo file: ' + fileObj.name);
                $('#pictureSelectedFile').show();
            });

            $('#btn_rm_picture').on('click', function(e) {
                e.preventDefault();
                if ($(this).hasClass('disabled')) return;
                $(this).addClass('disabled');
                $('#pictureAction').val('delete');
                $('#pictureImage').hide();
                $('#btn_rm_picture').hide();
                $('#pictureInputButton').show();
            });

            $( "#signatureInput" ).change(function() {
                $('#signatureInputButton').hide();
                const fileObj = $('#signatureInput')[0].files[0];
                $('#signatureSelectedFile').html('Nuovo file: ' + fileObj.name);
                $('#signatureSelectedFile').show();
            });

            $('#btn_rm_signature').on('click', function(e) {
                e.preventDefault();
                if ($(this).hasClass('disabled')) return;
                $(this).addClass('disabled');
                const id = $(this).data('promoter-id');
                if(!id) return;
                $('#signatureAction').val('delete');
                $('#signatureImage').hide();
                $('#btn_rm_signature').hide();
                $('#signatureInputButton').show();
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

            if ($('#addr2').val()!='') {
                $("#box2").show();
                $("#myBtnHide2").css("display", "inline-block");
                $("#myBtnShow2").css("display", "none");
            }

            if ($('#addr3').val()!='') {
                $("#box3").show();
                $("#myBtnHide3").css("display", "inline-block");
                $("#myBtnShow3").css("display", "none");
            }
        });
    </script>
@stop

@section('header')
    <div class="mt-3 py-4">
        <a href="{{ $fullUrl }}" class="btn btn-primary">Esci dalla modifica</a>
    </div>
@stop

@section('content')
    <h1 class="text-center mt-5">Modifica Promotore [{{$promoter->code}}]</h1>
    <div class="mx-auto p-5">

        <!--parte di codice che mostra eventuali errori quando si compila il form di creazione del nuovo promoter-->

    @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div class="col-12">{{ $error }}</div>
                @endforeach
            </div>
        @endif


        <form action="{{ route('promoters.update', ['id' => $promoter->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @method('PUT')
            <input type="hidden" name="code" value="{{ $promoter->code }}" />
            <div class="form-row">
                <div class="form-group col-3">
                    <label for="firstname">Nome</label>
                    <input type="text" name="firstname" value="{{ $promoter->firstname }}" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="lastname">Cognome</label>
                    <input type="text" name="lastname" value="{{ $promoter->lastname }}" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="mobile">Cellulare</label>
                    <input type="text" name="mobile" value="{{ $promoter->mobile }}" placeholder="opzionale" class="form-control">
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-3">
                    <label for="company">Azienda</label>
                    <input type="text" name="company" value="{{ $promoter->company }}" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="area">Area</label>
                    <input type="text" name="area" value="{{ $promoter->area }}" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="role">Ruolo</label>
                    <input type="text" name="role" value="{{ $promoter->role }}" class="form-control">
                </div>
                <div class="form-group col-3">
                    <label for="group">Team</label>
                    <input type="text" name="team" value="{{ $promoter->team }}" class="form-control" placeholder="opzionale">
                </div>
            </div>


            <div class="form-row">
                <div class="form-group col-3">
                    <label for="website">Sito Web</label>
                    <input name="website" id="website" type="text" class="form-control" value="{{ $promoter->website }}" placeholder="opzionale" />
                </div>
                <div class="form-group col-3">
                    <label for="extralogo">Logo</label>
                    <!-- <input name="extralogo" id="extralogo" type="text" class="form-control" value="{{ $promoter->extralogo }}" placeholder="opzionale" /> -->
                    <select name="extralogo" id="extralogo" class="form-control">
                        <option value="">Scegli il logo..(default Nessuno)</option>
                        @if($promoter->extralogo === 'none')
                            <option value="none" selected>Nessuno</option>
                            <option value="efpa">Logo EFPA</option>
                        @elseif ($promoter->extralogo === 'efpa')
                            <option value="none">Nessuno</option>
                            <option value="efpa" selected>Logo EFPA</option>
                        @endif
                    </select>
                </div>
            </div>



            <!--indirizzo-->
            <div class="form-row mb-3">
                <span class="mr-2">INDIRIZZO 1</span>
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
                        <label for="addr1">Indirizzo</label>
                        <input type="text" class="form-control" name="addr1" value="{{ $promoter->addr1 }}">
                    </div>
                    <div class="form-group col-4">
                        <label for="city1">Città</label>
                        <input type="text" class="form-control" name="city1" value="{{ $promoter->city1 }}">
                    </div>
                    <div class="form-group col-4">
                        <label for="prov1">Provincia</label>
                        <input type="text" class="form-control" name="prov1" value="{{ $promoter->prov1 }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="cap1">Cap</label>
                        <input type="text" class="form-control" name="cap1" value="{{ $promoter->cap1 }}">
                    </div>
                    <div class="form-group col-4">
                        <label for="phone1">Telefono</label>
                        <input type="text" class="form-control" name="phone1" value="{{ $promoter->phone1 }}" placeholder="opzionale">
                    </div>
                </div>
            </div>
            <!--indirizzo 2-->
            <div class="form-row my-3">
                <span class="mr-2">INDIRIZZO 2</span>
                <span class="mr-2" id="myBtnShow2" title="MOSTRA">
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <span id="myBtnHide2" style="display: none" title="NASCONDI">
                    <i class="bi bi-caret-up-fill"></i>
                </span>
            </div>
            <div id="box2" style="display: none; background-color: rgba(240,240,240,0.1);" class="border rounded p-3">
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="addr2">Indirizzo</label>
                        <input type="text" class="form-control" id="addr2" name="addr2" value="{{ $promoter->addr2 }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="city2">Città</label>
                        <input type="text" class="form-control" name="city2" value="{{ $promoter->city2 }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="prov2">Provincia</label>
                        <input type="text" class="form-control" name="prov2" value="{{ $promoter->prov2 }}" placeholder="opzionale">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="cap2">Cap</label>
                        <input type="text" class="form-control" name="cap2" value="{{ $promoter->cap2 }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="phone2">Telefono</label>
                        <input type="text" class="form-control" name="phone2" value="{{ $promoter->phone2 }}" placeholder="opzionale">
                    </div>
                </div>
            </div>
            <!--indirizzo 3-->
            <div class="form-row my-3">
                <span class="mr-2">INDIRIZZO 3</span>
                <span class="mr-2" id="myBtnShow3" title="MOSTRA">
                    <i class="bi bi-caret-down-fill"></i>
                </span>
                <span id="myBtnHide3" style="display: none" title="NASCONDI">
                    <i class="bi bi-caret-up-fill"></i>
                </span>
            </div>
            <div id="box3" style="display: none; background-color: rgba(240,240,240,0.1);" class="border rounded p-3">
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="addr3">Indirizzo</label>
                        <input type="text" class="form-control" id="addr3" name="addr3" value="{{ $promoter->addr3 }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="city3">Città</label>
                        <input type="text" class="form-control" name="city3" value="{{ $promoter->city3 }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="prov3">Provincia</label>
                        <input type="text" class="form-control" name="prov3" value="{{ $promoter->prov3 }}" placeholder="opzionale">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="cap3">Cap</label>
                        <input type="text" class="form-control" name="cap3" value="{{ $promoter->cap3 }}" placeholder="opzionale">
                    </div>
                    <div class="form-group col-4">
                        <label for="phone3">Telefono</label>
                        <input type="text" class="form-control" name="phone3" value="{{ $promoter->phone3 }}" placeholder="opzionale">
                    </div>
                </div>
            </div>



            <div class="form-row" style="display: none">
                <div class="form-group col-12">
                    <label for="description">Descrizione</label>
                    <textarea name="description" id="description" rows="1" class="form-control"> {{ $promoter->description }}</textarea>
                </div>
            </div>


            <div class="form-row">

                <div class="form-group col-2">
                    <label for="active">Stato: </label>
                    <div class="form-check mr-2">
                        <input type="radio" name="active" {{ $promoter->active === 1 ? ' checked ' : ''}} value=1 class="form-check-input">
                        <label for="active" class="form-check-label">Attivo</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="active" {{ $promoter->active === 0 ? ' checked ' : ''}} value=0 class="form-check-input">
                        <label for="active" class="form-check-label">Sospeso</label>
                    </div>
                </div>

                <div class="form-group col-5">
                    <label for="name">Immagine</label>
                    @if($foto !== null)
                        <button id="btn_rm_picture" data-promoter-id="{{ $promoter->id }}" style="border: none; background-color: transparent;" title="Cancella">
                            <i class="bi bi-trash-fill" style="color: red;"></i>
                        </button>
                        <label id="pictureInputButton" for="pictureInput" style="display: none; cursor:pointer" >
                            <i class="bi bi-plus-circle" style="color: green;"></i>
                        </label>
                        <input type="file" id="pictureInput" name="pictureInput" accept=".jpg"
                               style="display: none; border: none; background-color: transparent;" title="Aggiungi" />
                        <span id="pictureSelectedFile" style="display: none; font-weight: bold; color: #3490dc"></span>
                    @else
                        <button id="btn_rm_signature" data-promoter-id="{{ $promoter->id }}" style="display: none; border: none; background-color: transparent;" title="Cancella">
                            <i class="bi bi-trash-fill" style="color: red;"></i>
                        </button>
                        <label id="pictureInputButton" for="pictureInput" style="cursor:pointer" >
                            <i class="bi bi-plus-circle" style="color: green;"></i>
                        </label>
                        <input type="file" id="pictureInput" name="pictureInput" accept=".jpg"
                               style="display: none; border: none; background-color: transparent;" title="Aggiungi" />
                        <span id="pictureSelectedFile" style="display: none; font-weight: bold; color: #3490dc"></span>
                    @endif
                    <input type="hidden" id="oldPicture" name="oldPicture" value="{{ $fotopath }}" class="form-control">
                    <input type="hidden" id="pictureAction" name="pictureAction" value="none" class="form-control">
                </div>

                <div class="form-group col-5">
                    <label for="name">Firma</label>
                    @if($firma !== null)
                        <button id="btn_rm_signature" data-promoter-id="{{ $promoter->id }}" style="border: none; background-color: transparent;" title="Cancella">
                            <i class="bi bi-trash-fill" style="color: red;"></i>
                        </button>
                        <label id="signatureInputButton" for="signatureInput" style="display: none; cursor:pointer" >
                            <i class="bi bi-plus-circle" style="color: green;"></i>
                        </label>
                        <input type="file" id="signatureInput" name="signatureInput" accept=".jpg"
                               style="display: none; border: none; background-color: transparent;" title="Aggiungi" />
                        <span id="signatureSelectedFile" style="display: none; font-weight: bold; color: #3490dc"></span>
                    @else
                        <button id="btn_rm_signature" data-promoter-id="{{ $promoter->id }}" style="display: none; border: none; background-color: transparent;" title="Cancella">
                            <i class="bi bi-trash-fill" style="color: red;"></i>
                        </button>
                        <label id="signatureInputButton" for="signatureInput" style="cursor:pointer" >
                            <i class="bi bi-plus-circle" style="color: green;"></i>
                        </label>
                        <input type="file" id="signatureInput" name="signatureInput" accept=".jpg"
                               style="display: none; border: none; background-color: transparent;" title="Aggiungi" />
                        <span id="signatureSelectedFile" style="display: none; font-weight: bold; color: #3490dc"></span>
                    @endif
                    <input type="hidden" id="oldSignature" name="oldSignature" value="{{ $firmapath }}" class="form-control">
                    <input type="hidden" id="signatureAction" name="signatureAction" value="none" class="form-control">
                </div>

            </div>

            <div class="form-row">
                <div class="col-2"></div>

                <div class="form-group col-5">
                    @if($foto !== null)
                        <img id="pictureImage"  src="{{asset('storage/'.$fotopath)}}" height="128" alt="Foto del promotore" title="Foto del promotore" />
                    @endif
                </div>
                <div class="form-group col-5">
                    @if($firma !== null)
                        <img id="signatureImage" src="{{asset('storage/'.$firmapath)}}" height="128" alt="Firma del promotore" title="Firma del promotore" />
                    @endif
                </div>
            </div>


            <div class="form-group">
                <button type="submit" class="float-right btn btn-primary mt-2">AGGIORNA</button>
            </div>
        </form>
        @if (session('magicerror'))
        <div class="mt-3 alert alert-danger">
            {{ session('magicerror') }}
        </div>
        @endif


    </div>
@stop

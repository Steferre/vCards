<!-- aggiungiamo box che richiede una mail per un ingresso singolo
<div class="d-flex flex-column align-items-center">
    <h1 class="mb-5">AREA RISERVATA (PROMOTER)</h1>
    <form action="#" method="POST" class="form-inline">
        @csrf
        <div class="form-group">
            <input id="guestEmail" type="email" name="guest_email" class="form-control mr-3" placeholder="Inserisci la tua mail">
        </div>
        <button type="submit" class="btn btn-primary">Invia</button>
    </form>
    @if (session('magicmessage'))
        <div class="mt-3 alert alert-success">
            {{ session('magicmessage') }}
        </div>
    @endif
    @if (session('magicerror'))
        <div class="mt-3 alert alert-danger">
            {{ session('magicerror') }}
        </div>
    @endif
</div> -->
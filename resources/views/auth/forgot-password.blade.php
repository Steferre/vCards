<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4">
            <!--{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}-->
            {{ __('Hai dimenticato la tua password? Nessun problema.
                Inviaci il tuo indirizzo email, e ti invieremo un link per sceglierne una nuova!') }}
        </div>
        <div class="mb-3">
            <a href="{{ route('login') }}">Torna alla pagina di login</a>
        </div>

        <!-- Messaggio che la mail è stata inviata
        Session Status
        <x-auth-session-status class="mb-4" :status="session('status')" />
        -->

        <!-- Validation Errors -->
        <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> -->

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="btn btn-primary">
                    {{ __('vcards.resetlink') }}
                </x-button>
            </div>
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
    </x-auth-card>
</x-guest-layout>

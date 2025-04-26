@extends('layouts.app') <!-- Substitua 'layouts.app' pelo layout correto do seu projeto -->

@section('content')
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
            <div class="text-center mb-6">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar o seu endereço de e-mail e enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.') }}
            </div>

            <!-- Status da Sessão -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Erros de Validação -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Endereço de E-mail -->
                <div>
                    <x-label for="email" :value="__('E-mail')" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Enviar Link de Redefinição de Senha') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection

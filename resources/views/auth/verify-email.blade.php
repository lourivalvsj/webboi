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
                {{ __('Obrigado por se registrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, ficaremos felizes em enviar outro.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-button>
                            {{ __('Reenviar E-mail de Verificação') }}
                        </x-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Sair') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

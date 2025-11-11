@extends('layouts.app')

@section('title', 'Recuperar Senha')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-key me-2"></i>
                        {{ __('Recuperar Senha') }}
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar o seu endereço de e-mail e enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.') }}
                    </div>

                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Sistema de E-mail Temporariamente Indisponível</strong><br>
                        Se você não receber o e-mail de recuperação, entre em contato conosco:
                        <div class="mt-2">
                            <a href="https://wa.me/5564999671030" target="_blank" class="btn btn-success btn-sm me-2">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp: (64) 9.9967-1030
                            </a>
                            <a href="mailto:lourivalvsj@gmail.com" class="btn btn-primary btn-sm">
                                <i class="fas fa-envelope me-1"></i> E-mail: lourivalvsj@gmail.com
                            </a>
                        </div>
                    </div>

                    <!-- Status da Sessão -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                <i class="fas fa-envelope me-1"></i>{{ __('E-mail') }}
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                                       placeholder="Digite seu e-mail">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ __('Enviar Link de Recuperação') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('login') }}">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    {{ __('Voltar ao Login') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

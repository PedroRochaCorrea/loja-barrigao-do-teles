@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-4">
                <div class="card-header text-center fw-bold fs-4">
                    {{ __('Verifique seu endereço de e-mail') }}
                </div>

                <div class="card-body text-center">
                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            {{ __('Um novo link de verificação foi enviado para seu e-mail.') }}
                        </div>
                    @endif

                    <p class="mb-4">
                        {{ __('Antes de continuar, verifique seu e-mail clicando no link que enviamos.') }}
                    </p>

                    <p class="mb-4 text-muted">
                        {{ __('Se você não recebeu o e-mail, clique no botão abaixo para reenviar.') }}
                    </p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reenviar link de verificação') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger text-decoration-none">
                            {{ __('Sair') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

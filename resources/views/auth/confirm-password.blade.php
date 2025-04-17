@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header text-center fw-bold fs-4">
                    {{ __('Confirme sua senha') }}
                </div>

                <div class="card-body">
                    <p class="mb-4 text-center">
                        {{ __('Por favor, confirme sua senha antes de continuar.') }}
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Confirmar
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">
                        Esqueceu sua senha?
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

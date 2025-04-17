<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Esqueceu sua senha - Loja BarrigãoDoTeles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonte Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f3fdf6;
            font-family: 'Poppins', sans-serif;
            color: #2c7a61;
        }

        .brand {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .brand-loja {
            font-size: 1rem;
            color: #52a07c;
            font-weight: 400;
        }

        .brand-nome {
            font-size: 2.2rem;
            font-weight: 600;
            color: #2c7a61;
        }

        .forgot-box {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background-color: #2c7a61;
            border: none;
        }

        .btn-primary:hover {
            background-color: #3ca382;
        }

        .card-header {
            font-size: 1.3rem;
            font-weight: 600;
            background-color: #d1f0e0;
            color: #2c7a61;
        }

        .form-label {
            color: #2c7a61;
            font-weight: 500;
        }

        .card-footer a {
            color: #2c7a61;
            font-size: 0.9rem;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        .small-muted {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container py-5">

        <!-- Cabeçalho da loja -->
        <div class="d-flex justify-content-center mb-4">
            <div class="brand text-center">
                <span class="brand-loja">Loja</span>
                <span class="brand-nome">BarrigãoDoTeles</span>
            </div>
        </div>

        <!-- Caixa de redefinição -->
        <div class="card shadow forgot-box rounded-4">
            <div class="card-header text-center">
                Esqueceu sua senha?
            </div>
            <div class="card-body">
                <p class="mb-4 text-center small-muted">
                    Digite seu e-mail e enviaremos um link para redefinir sua senha.
                </p>

                {{-- Status --}}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Formulário --}}
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Botão --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            Enviar link de redefinição
                        </button>
                    </div>
                </form>
            </div>

            <!-- Link de voltar -->
            <div class="card-footer text-center">
                <a href="{{ route('login') }}" class="text-decoration-none small">
                    Voltar para o login
                </a>
            </div>
        </div>
    </div>
</body>
</html>

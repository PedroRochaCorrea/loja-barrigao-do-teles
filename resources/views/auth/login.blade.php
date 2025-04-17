<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Loja BarrigãoDoTeles</title>
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

        .login-box {
            max-width: 500px;
            margin: 0 auto;
        }

        .form-control, .form-select {
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

        .card-footer a {
            color: #2c7a61;
            font-weight: 500;
        }

        .btn-link {
            color: #2c7a61;
            font-size: 0.9rem;
        }

        .btn-link:hover {
            text-decoration: underline;
            color: #248b6a;
        }

        .alert {
            font-size: 0.9rem;
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

        <!-- Formulário de login -->
        <div class="card shadow login-box rounded-4">
            <div class="card-header text-center">
                Login
            </div>
            <div class="card-body">
                {{-- Mensagem de status --}}
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                {{-- Erros de validação --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Tipo de usuário --}}
                    <div class="mb-3">
                        <label for="role" class="form-label">Tipo de usuário</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">Selecione...</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="vendedor" {{ old('role') === 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                            <option value="cliente" {{ old('role') === 'cliente' ? 'selected' : '' }}>Cliente</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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

                    {{-- Senha --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lembrar de mim --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Lembrar de mim</label>
                    </div>

                    {{-- Ações --}}
                    <div class="d-flex justify-content-between align-items-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="btn btn-link">Esqueceu a senha?</a>
                        @endif
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>

            {{-- Rodapé com link de cadastro --}}
            <div class="card-footer text-center">
                <span class="text-muted">Ainda não tem uma conta?</span>
                <a href="{{ route('register') }}" class="ms-1">Cadastre-se</a>
            </div>
        </div>
    </div>
</body>
</html>

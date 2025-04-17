<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Loja BarrigãoDoTeles</title>
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

        .register-box {
            max-width: 550px;
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

        .form-label {
            color: #2c7a61;
            font-weight: 500;
        }

        .text-center a {
            color: #2c7a61;
            font-weight: 500;
        }

        .text-center a:hover {
            text-decoration: underline;
            color: #248b6a;
        }

        .invalid-feedback {
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

        <!-- Formulário de cadastro -->
        <div class="card shadow register-box rounded-4">
            <div class="card-header text-center">
                Cadastro de Usuário
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nome --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome completo</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Endereço de E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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

                    {{-- Senha --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmar senha --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control"
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    {{-- Botão de cadastro --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>

                    {{-- Link de login --}}
                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Já tem uma conta? Entrar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

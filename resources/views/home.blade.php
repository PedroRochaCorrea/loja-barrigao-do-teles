<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Bem-vindo - Loja BarrigãoDoTeles</title>
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
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-loja {
            font-size: 1.2rem;
            color: #52a07c;
            font-weight: 400;
        }

        .brand-nome {
            font-size: 2.8rem;
            font-weight: 700;
            color: #2c7a61;
        }

        .btn-custom {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            border-radius: 2rem;
        }

        .btn-login {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-login:hover {
            background-color: #3ca382;
        }

        .btn-register {
            border: 2px solid #2c7a61;
            color: #2c7a61;
        }

        .btn-register:hover {
            background-color: #e9f7f1;
        }
    </style>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">

        <!-- Logo -->
        <div class="brand">
            <div class="brand-loja">Seja bem-vindo à</div>
            <div class="brand-nome">Loja BarrigãoDoTeles</div>
        </div>

        <!-- Botões -->
        <div class="d-flex gap-3">
            <a href="{{ route('login') }}" class="btn btn-custom btn-login">
                Entrar
            </a>
            <a href="{{ route('register') }}" class="btn btn-custom btn-register">
                Cadastrar-se
            </a>
        </div>

    </div>
</body>
</html>

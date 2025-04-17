<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Compra Finalizada</title>
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
            text-align: center;
        }

        .page-container {
            max-width: 600px;
            margin: 0 auto;
            padding-top: 80px;
        }

        .icon-check {
            font-size: 4rem;
            color: #2c7a61;
        }

        .success-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 20px 0;
        }

        .btn-outline {
            border: 1px solid #2c7a61;
            color: #2c7a61;
            background-color: white;
        }

        .btn-outline:hover {
            background-color: #cdeee0;
            color: #2c7a61;
        }

        .btn-green {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-green:hover {
            background-color: #3ca382;
        }

        .btn-group-custom {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="page-container">
    <i class="bi bi-check-circle-fill icon-check"></i>
    <h1 class="success-title">Compra finalizada com sucesso!</h1>
    <p class="text-muted">Obrigado por comprar com a gente.</p>

    <div class="btn-group-custom">
        <a href="{{ route('cliente.historico') }}" class="btn btn-green">
            <i class="bi bi-clock-history me-1"></i> Ver Histórico
        </a>
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-outline">
            <i class="bi bi-house-door me-1"></i> Voltar ao Painel
        </a>
    </div>
</div>
</body>
</html>

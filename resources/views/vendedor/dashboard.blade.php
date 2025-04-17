<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Loja BarrigãoDoTeles - Painel do Vendedor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones -->
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

        .category-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #2c7a61;
        }

        .logout-btn {
            font-size: 0.9rem;
            border: 1px solid #2c7a61;
            color: #2c7a61;
            background-color: white;
        }

        .logout-btn:hover {
            background-color: #2c7a61;
            color: white;
        }

        .card-header {
            background-color: #d1f0e0;
            font-weight: 600;
            color: #2c7a61;
        }

        .list-group-item {
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #e9f7f1;
            border-left: 4px solid #2c7a61;
            color: #2c7a61;
        }

        .list-icon {
            margin-right: 8px;
            color: #2c7a61;
        }
    </style>
</head>
<body>
<div class="container py-5">

    <!-- Cabeçalho com nome da loja e botão sair -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="brand">
            <span class="brand-loja">Loja</span>
            <span class="brand-nome">BarrigãoDoTeles</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn logout-btn">Sair</button>
        </form>
    </div>

    <!-- Título -->
    <h3 class="category-title mb-4">Painel do Vendedor</h3>

    <!-- Cartão com links -->
    <div class="card shadow-sm">
        <div class="card-header">
            Bem-vindo, {{ Auth::user()->name }}
        </div>
        <div class="card-body">
            <p class="mb-4">Selecione uma opção abaixo:</p>
            <div class="list-group">
                <a href="{{ route('vendedor.vendas.historico') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-clock-history list-icon"></i> Ver todas as vendas
                </a>
                <a href="{{ route('vendedor.venda.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-cart-plus list-icon"></i> Montar Nova Venda
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

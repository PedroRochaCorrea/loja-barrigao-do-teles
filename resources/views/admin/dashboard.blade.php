<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Loja BarrigãoDoTeles - Painel do Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f3fdf6;
            font-family: 'Poppins', sans-serif;
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

        .card-category {
            transition: all 0.3s ease;
            border-radius: 1rem;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #2c7a61;
        }

        .card-category:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            background-color: #e9f7f1;
        }

        .card-category h5 {
            margin: 0;
            font-weight: 600;
            color: #2c7a61;
        }

        .logout-btn {
            font-size: 0.9rem;
            border: 1px solid #2c7a61;
            color: #2c7a61;
        }

        .logout-btn:hover {
            background-color: #2c7a61;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container py-5">
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

        <h3 class="category-title mb-4">Painel Administrativo</h3>

        <div class="row g-4">
            <div class="col-md-4">
                <a href="{{ route('products.index') }}" class="text-decoration-none">
                    <div class="card card-category bg-white shadow-sm">
                        <h5>Gerenciar Produtos</h5>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('categories.index') }}" class="text-decoration-none">
                    <div class="card card-category bg-white shadow-sm">
                        <h5>Gerenciar Categorias</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

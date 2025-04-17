<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento</title> <!-- ✅ Título da aba -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Google Fonts -->
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
            font-size: 1.8rem;
            font-weight: 700;
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

        .btn-voltar {
            border: 1px solid #2c7a61;
            color: #2c7a61;
            background-color: white;
        }

        .btn-voltar:hover {
            background-color: #cdeee0;
            color: #2c7a61;
        }

        .btn-add {
            background-color: #2c7a61;
            color: white;
        }

        .btn-add:hover {
            background-color: #3ca382;
        }

        .btn-editar {
            border: 1px solid #2c7a61;
            background-color: #d2f2e0;
            color: #2c7a61;
        }

        .btn-editar:hover {
            background-color: #b2e6ce;
        }

        .btn-excluir {
            border: 1px solid #2c7a61;
            background-color: #e3f6ed;
            color: #2c7a61;
        }

        .btn-excluir:hover {
            background-color: #cceadd;
        }

        .table th {
            background-color: #d1f0e0;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .no-categories {
            background-color: #eafaf1;
            border: 1px solid #c1e9d0;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <!-- Cabeçalho superior -->
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

    <!-- Título da seção -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="category-title">Gerenciar Categorias</h2>
            <p class="mb-0">Veja, edite ou remova as categorias cadastradas.</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-voltar me-2">← Voltar</a>
            <a href="{{ route('categories.create') }}" class="btn btn-add">+ Nova Categoria</a>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tabela -->
    @if($categories->isEmpty())
        <div class="no-categories">
            <h5>Nenhuma categoria cadastrada no momento.</h5>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered shadow-sm text-center align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Código</th>
                        <th>Ícone</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->code }}</td>
                            <td>
                                @if ($category->icon)
                                    <i class="bi {{ $category->icon }}" style="font-size: 1.5rem;"></i><br>
                                    <small class="text-muted">{{ $category->icon }}</small>
                                @else
                                    <span class="text-muted">–</span>
                                @endif
                            </td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-editar me-1">Editar</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Deseja excluir esta categoria?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
</body>
</html>

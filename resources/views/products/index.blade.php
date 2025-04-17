<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento</title> <!-- ✅ Nome da aba corrigido -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .no-products {
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
            <h2 class="category-title">Gerenciar Produtos</h2>
            <p class="mb-0">Veja, edite ou remova os produtos cadastrados.</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-voltar me-2">← Voltar</a>
            <a href="{{ route('products.create') }}" class="btn btn-add">+ Adicionar Produto</a>
        </div>
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Lista de produtos -->
    @if($products->isEmpty())
        <div class="no-products">
            <h5>Nenhum produto cadastrado no momento.</h5>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered shadow-sm text-center align-middle">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                @if($product->photo)
                                    <img src="{{ asset('storage/' . $product->photo) }}" alt="Foto" width="60" class="rounded">
                                @else
                                    <span class="text-muted">Sem imagem</span>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->category->name ?? '—' }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-editar me-1">Editar</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Deseja excluir este produto?')">
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

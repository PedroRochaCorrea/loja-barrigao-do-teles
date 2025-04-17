<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- jQuery e Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

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

        .btn-atualizar {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-atualizar:hover {
            background-color: #3ca382;
        }

        .form-label {
            font-weight: 600;
        }

        .alert ul {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <!-- Cabeçalho -->
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

    <!-- Título e botão voltar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="category-title mb-0">Editar Produto</h2>
        <a href="{{ route('products.index') }}" class="btn btn-voltar">← Voltar</a>
    </div>

    <!-- Mensagem de erro -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erro!</strong> Corrija os campos abaixo:
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Preço:</label>
            <input type="text" name="price" id="price" value="{{ old('price', number_format($product->price, 2, ',', '.')) }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Estoque:</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoria:</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Selecione</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="photo" class="form-label">Foto do Produto:</label>
            <input type="file" name="photo" id="photo" class="form-control">
            @if($product->photo)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="Foto atual" width="120" class="rounded shadow-sm">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-atualizar">Atualizar Produto</button>
    </form>
</div>

<!-- Máscara para campo de preço -->
<script>
    $('#price').mask('#.##0,00', {reverse: true});
</script>
</body>
</html>

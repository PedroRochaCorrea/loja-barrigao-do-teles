<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento</title>
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

        .btn-salvar {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-salvar:hover {
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
        <h2 class="category-title mb-0">Criar Nova Categoria</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-voltar">← Voltar</a>
    </div>

    <!-- Erros -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erro!</strong> Corrija os campos abaixo:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Sucesso -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Código:</label>
            <input type="text" name="code" id="code" value="{{ old('code') }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Ícone:</label>
            <select name="icon" id="icon" class="form-select">
                <option value="">Nenhum</option>
                @php
                    $icons = ['bi-cart', 'bi-cup-hot', 'bi-house', 'bi-telephone', 'bi-heart'];
                @endphp
                @foreach($icons as $icon)
                    <option value="{{ $icon }}" {{ old('icon') == $icon ? 'selected' : '' }}>
                        {{ $icon }}
                    </option>
                @endforeach
            </select>
            <div class="mt-2">
                <i id="previewIcon" class="bi {{ old('icon') }}" style="font-size: 2rem;"></i>
            </div>
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Descrição:</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-salvar">Salvar Categoria</button>
    </form>
</div>

<!-- Script para visualização do ícone selecionado -->
<script>
    document.getElementById('icon').addEventListener('change', function () {
        const iconClass = this.value;
        const preview = document.getElementById('previewIcon');
        preview.className = 'bi ' + iconClass;
    });
</script>
</body>
</html>

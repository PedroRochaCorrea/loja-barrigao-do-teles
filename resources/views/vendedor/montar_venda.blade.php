<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Montar Nova Venda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Fonte Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f3fdf6;
            font-family: 'Poppins', sans-serif;
            color: #2c7a61;
        }

        .brand-nome {
            font-size: 2.2rem;
            font-weight: 700;
            color: #2c7a61;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .btn-voltar {
            border: 1px solid #2c7a61;
            background-color: white;
            color: #2c7a61;
            padding: 8px 16px;
            font-size: 0.95rem;
        }

        .btn-voltar:hover {
            background-color: #cdeee0;
            color: #2c7a61;
        }

        .btn-verde {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-verde:hover {
            background-color: #3ca382;
        }

        .btn-remover, .btn-esvaziar {
            background-color: #e3f6ed;
            color: #2c7a61;
            border: 1px solid #2c7a61;
            font-size: 0.85rem;
            padding: 5px 12px;
            height: auto;
            line-height: 1.2;
        }

        .btn-remover:hover, .btn-esvaziar:hover {
            background-color: #cceadd;
        }

        .table th {
            background-color: #d1f0e0;
        }

        .form-label {
            font-weight: 600;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
        }
    </style>
</head>
<body>
<div class="container py-5">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Montar Nova Venda</h2>
        <a href="{{ route('vendedor.dashboard') }}" class="btn btn-voltar">← Voltar ao Painel</a>
    </div>

    <!-- Mensagens -->
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    @endif

    <!-- Formulário de produto -->
    <form action="{{ route('vendedor.venda.adicionar') }}" method="POST" class="row g-3 align-items-end mt-3">
        @csrf
        <div class="col-md-6">
            <label for="produto_id" class="form-label">Produto</label>
            <select name="produto_id" id="produto_id" class="form-select" required>
                <option value="">Selecione um produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->name }} (Estoque: {{ $produto->stock }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" required>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-verde w-100">Adicionar</button>
        </div>
    </form>

    <!-- Lista de itens -->
    @if(count($carrinho) > 0)
        <h4 class="mt-5">Itens na Venda</h4>
        <table class="table table-bordered table-striped mt-3 align-middle">
            <thead>
                <tr class="text-center">
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrinho as $item)
                    <tr class="text-center">
                        <td>{{ $item['nome'] }}</td>
                        <td>{{ $item['quantidade'] }}</td>
                        <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('vendedor.venda.remover', $item['produto_id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-remover btn-sm">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr class="fw-bold">
                    <td colspan="3" class="text-end">Total:</td>
                    <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Ações finais -->
        <div class="d-flex justify-content-between mt-4 flex-column flex-md-row gap-3">
            <a href="{{ route('vendedor.venda.esvaziar') }}" class="btn btn-esvaziar btn-sm">Esvaziar Venda</a>

            <form action="{{ route('vendedor.venda.finalizar') }}" method="POST" class="d-flex align-items-center gap-2 flex-wrap">
                @csrf
                <label for="forma_pagamento" class="form-label mb-0">Forma de Pagamento:</label>
                <select name="forma_pagamento" id="forma_pagamento" class="form-select" required>
                    <option value="">Selecione</option>
                    <option value="Dinheiro">Dinheiro</option>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Cartão de Débito">Cartão de Débito</option>
                    <option value="Pix">Pix</option>
                    <option value="Boleto">Boleto</option>
                    <option value="Outros">Outros</option>
                </select>
                <button type="submit" class="btn btn-verde">Finalizar Venda</button>
            </form>
        </div>
    @endif
</div>

<!-- Scripts Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#produto_id').select2({
            placeholder: 'Selecione um produto',
            width: '100%'
        });
    });
</script>
</body>
</html>

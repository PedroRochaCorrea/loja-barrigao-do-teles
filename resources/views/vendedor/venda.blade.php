<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Montar Venda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonte Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f3fdf6;
            font-family: 'Poppins', sans-serif;
            color: #2c7a61;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c7a61;
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

        .btn-verde {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-verde:hover {
            background-color: #3ca382;
        }

        .btn-remover {
            background-color: #e3f6ed;
            color: #2c7a61;
            border: 1px solid #2c7a61;
        }

        .btn-remover:hover {
            background-color: #cceadd;
        }

        .btn-cancelar {
            border: 1px solid #dc3545;
            color: #dc3545;
            background-color: white;
        }

        .btn-cancelar:hover {
            background-color: #f8d7da;
        }

        .form-label {
            font-weight: 600;
        }

        .table th {
            background-color: #d1f0e0;
        }

        .alert-info {
            background-color: #eafaf1;
            border: 1px solid #c1e9d0;
            color: #2c7a61;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Montar Venda</h2>
        <a href="{{ route('vendedor.dashboard') }}" class="btn btn-voltar">← Voltar ao Painel</a>
    </div>

    <!-- Mensagens -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Formulário para adicionar item -->
    <form action="{{ route('vendedor.venda.adicionar') }}" method="POST" class="row g-3 mb-4">
        @csrf
        <div class="col-md-5">
            <label for="product_id" class="form-label">Produto</label>
            <select name="product_id" id="product_id" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach ($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->name }} (Estoque: {{ $produto->stock }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="quantity" class="form-label">Quantidade</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-verde w-100">Adicionar</button>
        </div>
    </form>

    <!-- Tabela de itens -->
    @php $totalVenda = 0; @endphp

    @if(count($itensVenda) > 0)
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total do Item</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itensVenda as $item)
                        @php
                            $itemTotal = $item['price'] * $item['quantity'];
                            $totalVenda += $itemTotal;
                        @endphp
                        <tr class="text-center">
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($itemTotal, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('vendedor.venda.remover', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-remover">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary fw-bold">
                    <tr>
                        <td colspan="3" class="text-end">Total da Venda:</td>
                        <td colspan="2">R$ {{ number_format($totalVenda, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Finalizar ou Cancelar -->
        <form action="{{ route('vendedor.venda.finalizar') }}" method="POST" class="mt-4">
            @csrf
            <div class="row align-items-end g-3">
                <div class="col-md-4">
                    <label for="payment_method" class="form-label">Forma de Pagamento</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">Selecione...</option>
                        <option value="Dinheiro">Dinheiro</option>
                        <option value="Cartão de Crédito">Cartão de Crédito</option>
                        <option value="Cartão de Débito">Cartão de Débito</option>
                        <option value="Pix">Pix</option>
                        <option value="Boleto">Boleto</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-verde w-100">Finalizar Venda</button>

                    <form action="{{ route('vendedor.venda.limpar') }}" method="POST" class="w-100">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-cancelar w-100">🗑️ Cancelar Venda</button>
                    </form>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-info mt-4">Nenhum produto adicionado à venda.</div>
    @endif
</div>
</body>
</html>

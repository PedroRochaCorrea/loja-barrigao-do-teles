<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Compras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f3fdf6;
            font-family: 'Poppins', sans-serif;
            color: #2c7a61;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #2c7a61;
        }

        .btn-voltar {
            border: 1px solid #2c7a61;
            background-color: white;
            color: #2c7a61;
            font-weight: 500;
        }

        .btn-voltar:hover {
            background-color: #cdeee0;
        }

        /* Tabela principal */
        .main-table {
            font-size: 0.95rem;
        }

        .main-table th {
            background-color: #d1f0e0;
            color: #2c7a61;
            text-align: center;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .main-table td {
            vertical-align: middle;
        }

        /* Tabela interna de itens */
        .subtable {
            background-color: #f8fcf9;
        }

        .subtable th {
            background-color: #e9f7f1;
            text-align: center;
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
        }

        .subtable td {
            font-size: 0.9rem;
        }

        .alert-info {
            background-color: #eafaf1;
            border: 1px solid #c1e9d0;
            color: #2c7a61;
        }

        .alert-success {
            border-left: 5px solid #2c7a61;
        }
    </style>
</head>
<body>
<div class="container py-5">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Histórico de Compras</h2>
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-voltar">
            <i class="bi bi-arrow-left"></i> Voltar ao Painel
        </a>
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Nenhuma compra -->
    @if($vendas->isEmpty())
        <div class="alert alert-info">Nenhuma compra encontrada.</div>
    @else
        <!-- Tabela de Compras -->
        <div class="table-responsive">
            <table class="table table-bordered main-table shadow-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data</th>
                        <th>Forma de Pagamento</th>
                        <th>Total</th>
                        <th>Itens da Compra</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendas as $index => $venda)
                        <tr>
                            <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($venda->sale_date)->format('d/m/Y H:i') }}</td>
                            <td>{{ $venda->payment_method }}</td>
                            <td class="text-end">R$ {{ number_format($venda->total, 2, ',', '.') }}</td>
                            <td>
                                <table class="table table-sm table-striped subtable mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Qtd</th>
                                            <th>Unitário</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($venda->itens as $item)
                                            <tr>
                                                <td>{{ $item->product->name ?? 'Produto removido' }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-end">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                                <td class="text-end">
                                                    R$ {{ number_format($item->unit_price * $item->quantity, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Compras</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
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
        }

        .btn-verde {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-verde:hover {
            background-color: #3ca382;
        }

        .btn-continuar, .btn-painel {
            border: 1px solid #2c7a61;
            color: #2c7a61;
            background-color: white;
        }

        .btn-continuar:hover, .btn-painel:hover {
            background-color: #cdeee0;
        }

        .btn-remover {
            background-color: #e3f6ed;
            color: #2c7a61;
            border: 1px solid #2c7a61;
        }

        .btn-remover:hover {
            background-color: #cceadd;
        }

        .table thead {
            background-color: #d1f0e0;
        }

        .form-label {
            font-weight: 600;
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

    <!-- Título e botões superiores -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row gap-3">
        <h2 class="page-title mb-0">Lista de Compras</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('produtos.cliente') }}" class="btn btn-continuar">
                ← Continuar Comprando
            </a>
            <a href="{{ route('cliente.dashboard') }}" class="btn btn-painel">
                🏠 Voltar ao Painel
            </a>
        </div>
    </div>

    <!-- Mensagens -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Lista vazia -->
    @if(count($cart) === 0)
        <div class="alert alert-info">Sua lista de compras está vazia.</div>
    @else
        <!-- Tabela -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="text-center">
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Subtotal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                        @php
                            $product = $products->firstWhere('id', $item['id']);
                            $subtotal = $product ? $product->price * $item['quantity'] : 0;
                            $total += $subtotal;
                        @endphp
                        <tr class="text-center">
                            <td>{{ $product->name ?? 'Produto não encontrado' }}</td>
                            <td>R$ {{ number_format($product->price ?? 0, 2, ',', '.') }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('shopping.list.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-remover">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="table-light fw-bold text-center">
                        <td colspan="3">Total Geral:</td>
                        <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Ações -->
        <div class="d-flex justify-content-between mt-4 flex-column flex-md-row gap-3">
            <form action="{{ route('shopping.list.clear') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja limpar a lista?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-remover">Limpar Lista</button>
            </form>

            <a href="{{ route('shopping.list.checkout') }}" class="btn btn-verde">Finalizar Compra</a>
        </div>
    @endif
</div>
</body>
</html>

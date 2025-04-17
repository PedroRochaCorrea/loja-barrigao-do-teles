<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Revisar Compra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e Ícones -->
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
            color: #2c7a61;
        }

        .table > thead {
            background-color: #d1f0e0;
        }

        .btn-confirmar {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-confirmar:hover {
            background-color: #3ca382;
        }

        .alert-info {
            background-color: #eafaf1;
            border: 1px solid #c1e9d0;
        }

        .form-label {
            font-weight: 600;
        }

        a {
            color: #2c7a61;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container py-5">

    <!-- Título da Página -->
    <h2 class="page-title mb-4">Revisar Compra</h2>

    <!-- Mensagens -->
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Lista Vazia -->
    @if (count($cart) === 0)
        <div class="alert alert-info">
            Sua lista está vazia. <a href="{{ route('produtos.cliente') }}">Ver produtos</a>
        </div>
    @else
        <!-- Tabela de Itens -->
        <table class="table table-bordered table-striped align-middle">
            <thead class="text-center">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $totalGeral = 0; @endphp
                @foreach($cart as $item)
                    @php
                        $subtotal = $item['quantity'] * $item['price'];
                        $totalGeral += $subtotal;
                    @endphp
                    <tr class="text-center">
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="fw-bold text-center">
                    <td colspan="3" class="text-end">Total Geral:</td>
                    <td>R$ {{ number_format($totalGeral, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Formulário de Finalização -->
        <form action="{{ route('shopping.list.confirm') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="payment_method" class="form-label">Forma de Pagamento</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="">Selecione</option>
                    <option value="Dinheiro">Dinheiro</option>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Cartão de Débito">Cartão de Débito</option>
                    <option value="Pix">Pix</option>
                    <option value="Boleto">Boleto</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>

            <button type="submit" class="btn btn-confirmar">Confirmar Compra</button>
        </form>
    @endif
</div>
</body>
</html>

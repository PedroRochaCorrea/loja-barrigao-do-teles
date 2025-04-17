<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Produto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .product-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            max-width: 600px;
            margin: auto;
        }
        .product-info img {
            max-width: 200px;
            height: auto;
            display: block;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .product-info p {
            font-size: 18px;
            margin: 10px 0;
        }
        .product-info strong {
            color: #333;
        }
        .message {
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Detalhes do Produto</h1>

    {{-- Verifica se o produto foi encontrado --}}
    @if($product)

        <div class="product-info">
            {{-- Exibe a imagem do produto se houver --}}
            @if($product->photo)
                <img src="{{ asset('storage/' . $product->photo) }}" alt="Foto do Produto">
            @endif

            {{-- Exibe as informações do produto --}}
            <p><strong>Nome:</strong> {{ $product->name }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            <p><strong>Estoque:</strong> {{ $product->stock }}</p>

            {{-- Exibe a categoria do produto, caso tenha --}}
            <p><strong>Categoria:</strong> {{ $product->category->name ?? 'Sem categoria' }}</p>
        </div>

    @else
        <div class="message">
            Produto não encontrado 😢
        </div>
    @endif

    {{-- Link para voltar à lista de produtos --}}
    <a href="{{ route('products.index') }}">← Voltar para a lista de produtos</a>

</body>
</html>

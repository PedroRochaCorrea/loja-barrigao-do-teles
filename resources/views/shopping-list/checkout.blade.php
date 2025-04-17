@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Finalizar Compra</h2>

    <a href="{{ route('shopping.list.index') }}" class="btn btn-secondary mb-3">← Voltar</a>

    <form action="{{ route('shopping.list.confirm') }}" method="POST">
        @csrf

        <div class="mb-3">
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

        <div class="mb-4">
            <h5>Resumo:</h5>
            <ul class="list-group">
                @foreach($items as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $item['name'] }} (x{{ $item['quantity'] }})
                        <span>R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <button type="submit" class="btn btn-primary">Confirmar Compra</button>
    </form>
</div>
@endsection

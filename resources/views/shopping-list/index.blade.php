@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Minha Lista de Compras</h2>

    <div class="mb-3">
        <a href="{{ route('cliente.dashboard') }}" class="btn btn-secondary">← Voltar ao painel</a>
        <a href="{{ route('produtos.cliente') }}" class="btn btn-primary ms-2">➕ Adicionar mais produtos</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $totalCompra = 0;
    @endphp

    @if(count($items) > 0)
        <div class="table-responsive">
            <table class="table table-bordered align-middle table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total do Item</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                            <td>
                                R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                                @php
                                    $totalCompra += $item['price'] * $item['quantity'];
                                @endphp
                            </td>
                            <td>
                                <form action="{{ route('shopping.list.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary fw-bold">
                    <tr>
                        <td colspan="3" class="text-end">Total da Compra:</td>
                        <td colspan="2">R$ {{ number_format($totalCompra, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Botões --}}
        <div class="d-flex justify-content-between mt-4">
            <form action="{{ route('shopping.list.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">🗑️ Esvaziar Lista</button>
            </form>

            <a href="{{ route('shopping.list.checkout') }}" class="btn btn-success">Finalizar Compra</a>
        </div>
    @else
        <div class="alert alert-info">Sua lista de compras está vazia.</div>
    @endif
</div>
@endsection

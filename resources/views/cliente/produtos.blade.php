<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Produtos - BarrigãoDoTeles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        body {
            background-color: #f3fdf6;
            font-family: 'Poppins', sans-serif;
            color: #2c7a61;
        }

        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .btn-voltar {
            border: 1px solid #2c7a61;
            color: #2c7a61;
            background-color: white;
        }

        .btn-voltar:hover {
            background-color: #cdeee0;
        }

        .btn-carrinho {
            background-color: #2c7a61;
            color: white;
            border: none;
        }

        .btn-carrinho:hover {
            background-color: #3ca382;
        }

        .card-title {
            font-weight: 600;
        }

        .card:hover {
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }

        .form-control {
            font-size: 0.95rem;
        }

        .card-img-top {
            border-bottom: 1px solid #f0f0f0;
        }

        .alert-info {
            background-color: #eafaf1;
            border: 1px solid #c1e9d0;
            color: #2c7a61;
        }

        .select2-container .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .select2-selection__rendered {
            line-height: 24px;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <!-- Banner da loja -->
    <div class="text-center p-5 bg-white border-bottom shadow-sm">
        <h6 class="mb-1 text-muted">Loja</h6>
        <h1 class="brand-title text-success">BarrigãoDoTeles</h1>
    </div>

    <div class="container my-5">
        <!-- Cabeçalho de ações e busca -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <h3 class="mb-0 fw-semibold">Produtos</h3>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Filtro com Select2 -->
                <div style="min-width: 240px;">
                    <select id="filtro-produto" class="form-select w-100">
                        <option value="">Buscar produto...</option>
                        @foreach($produtos as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Botões -->
                <a href="{{ route('cliente.dashboard') }}" class="btn btn-voltar">
                    <i class="bi bi-arrow-left me-1"></i> Voltar ao Painel
                </a>
                <a href="{{ route('shopping.list.index') }}" class="btn btn-carrinho">
                    <i class="bi bi-cart-check-fill me-1"></i> Lista de Compras
                </a>
            </div>
        </div>

        <!-- Listagem de produtos -->
        <div class="row g-4">
            @forelse($produtos as $produto)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 produto-card" data-id="{{ $produto->id }}">
                    <div class="card h-100 shadow-sm text-center border-0">
                        @if ($produto->photo)
                            <img src="{{ asset('images/' . $produto->photo) }}"
                                 alt="{{ $produto->name }}"
                                 class="card-img-top p-4"
                                 style="height: 180px; object-fit: contain;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-success">{{ $produto->name }}</h6>
                            <p class="mb-1 text-muted">R$ {{ number_format($produto->price, 2, ',', '.') }}</p>
                            <small class="text-muted mb-3">Estoque: {{ $produto->stock }}</small>

                            <form method="POST" action="{{ route('shopping.list.add', $produto->id) }}" class="mt-auto">
                                @csrf
                                <div class="mb-2">
                                    <input type="number"
                                           name="quantity"
                                           value="1"
                                           min="1"
                                           max="{{ $produto->stock }}"
                                           class="form-control text-center"
                                           required>
                                </div>
                                <button type="submit"
                                        class="btn btn-carrinho w-100"
                                        @if($produto->stock <= 0) disabled @endif>
                                    {{ $produto->stock > 0 ? 'Adicionar à Lista' : 'Indisponível' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">Nenhum produto disponível no momento.</div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Script do filtro -->
    <script>
        $(document).ready(function() {
            // Inicia o Select2 com placeholder
            $('#filtro-produto').select2({
                placeholder: "Buscar produto...",
                allowClear: true
            });

            // Lógica de filtro
            $('#filtro-produto').on('change', function () {
                const selectedId = $(this).val();

                if (selectedId && selectedId !== '') {
                    $('.produto-card').hide();
                    $(`.produto-card[data-id="${selectedId}"]`).show();
                } else {
                    $('.produto-card').show();
                }
            });
        });
    </script>
</body>
</html>

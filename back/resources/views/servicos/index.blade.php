@extends('layouts.app')

@section('title', 'Serviços Disponíveis - Conecta Bairro')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Serviços Disponíveis</h1>
    <a href="{{ route('servicos.create') }}" class="btn btn-primary">
        Novo Serviço
    </a>
</div>

@if($servicos->count() > 0)
    <div class="row">
        @foreach($servicos as $servico)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $servico->nome }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $servico->nome_prestador }}</h6>
                        <p class="card-text">{{ Str::limit($servico->descricao, 100) }}</p>
                        <div class="mb-2">
                            <small class="text-muted">
                                <strong>Telefone:</strong> {{ $servico->telefone }}<br>
                                <strong>Local:</strong> {{ $servico->bairro }}, {{ $servico->cidade }}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('servicos.show', $servico) }}" class="btn btn-outline-primary btn-sm">
                                Ver Detalhes
                            </a>
                            <a href="{{ route('servicos.edit', $servico) }}" class="btn btn-outline-secondary btn-sm">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('servicos.destroy', $servico) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $servicos->links() }}
    </div>
@else
    <div class="alert alert-info text-center">
        <h4>Nenhum serviço cadastrado ainda</h4>
        <p>Seja o primeiro a divulgar seu serviço na comunidade!</p>
        <a href="{{ route('servicos.create') }}" class="btn btn-primary">
            Cadastrar Primeiro Serviço
        </a>
    </div>
@endif
@endsection 
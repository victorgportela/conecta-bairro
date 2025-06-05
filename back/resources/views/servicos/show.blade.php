@extends('layouts.app')

@section('title', $servico->nome . ' - Conecta Bairro')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $servico->nome }}</h4>
                <div class="btn-group">
                    <a href="{{ route('servicos.edit', $servico) }}" class="btn btn-outline-primary btn-sm">
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
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-primary">{{ $servico->nome_prestador }}</h5>
                        <p class="text-muted mb-3">{{ $servico->bairro }}, {{ $servico->cidade }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h6 class="text-success">
                            📞 {{ $servico->telefone }}
                        </h6>
                        <small class="text-muted">
                            Cadastrado em {{ $servico->created_at->format('d/m/Y \à\s H:i') }}
                        </small>
                    </div>
                </div>

                <hr>

                <h6>Descrição do Serviço:</h6>
                <p class="lead">{{ $servico->descricao }}</p>

                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <strong>Prestador:</strong><br>
                        {{ $servico->nome_prestador }}
                    </div>
                    <div class="col-md-4">
                        <strong>Telefone:</strong><br>
                        {{ $servico->telefone }}
                    </div>
                    <div class="col-md-4">
                        <strong>Localização:</strong><br>
                        {{ $servico->bairro }}, {{ $servico->cidade }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('servicos.index') }}" class="btn btn-secondary">
                        ← Voltar para Lista
                    </a>
                    <div class="btn-group">
                        <a href="tel:{{ $servico->telefone }}" class="btn btn-success">
                            📞 Ligar Agora
                        </a>
                        <a href="https://wa.me/55{{ preg_replace('/[^0-9]/', '', $servico->telefone) }}" 
                           target="_blank" class="btn btn-primary">
                            💬 WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
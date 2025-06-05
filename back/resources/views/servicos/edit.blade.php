@extends('layouts.app')

@section('title', 'Editar Serviço - Conecta Bairro')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Editar Serviço</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('servicos.update', $servico) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Serviço</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome', $servico->nome) }}" 
                               placeholder="Ex: Pedreiro, Eletricista, Costureira...">
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nome_prestador" class="form-label">Nome do Prestador</label>
                        <input type="text" class="form-control @error('nome_prestador') is-invalid @enderror" 
                               id="nome_prestador" name="nome_prestador" value="{{ old('nome_prestador', $servico->nome_prestador) }}"
                               placeholder="Seu nome ou nome da empresa">
                        @error('nome_prestador')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição do Serviço</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" name="descricao" rows="4"
                                  placeholder="Descreva seu serviço, experiência e especialidades...">{{ old('descricao', $servico->descricao) }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone para Contato</label>
                                <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                                       id="telefone" name="telefone" value="{{ old('telefone', $servico->telefone) }}"
                                       placeholder="(11) 99999-9999">
                                @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                                       id="cidade" name="cidade" value="{{ old('cidade', $servico->cidade) }}"
                                       placeholder="Nome da cidade">
                                @error('cidade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control @error('bairro') is-invalid @enderror" 
                               id="bairro" name="bairro" value="{{ old('bairro', $servico->bairro) }}"
                               placeholder="Nome do bairro">
                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('servicos.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Atualizar Serviço
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
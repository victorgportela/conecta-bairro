<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServicoController extends Controller
{
    public function index()
    {
        $servicos = Servico::latest()->get();
        return response()->json($servicos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'nome_prestador' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
        ]);

        $servico = Servico::create($request->all());

        return response()->json([
            'message' => 'Serviço criado com sucesso',
            'servico' => $servico
        ], 201);
    }

    public function show($id)
    {
        $servico = Servico::findOrFail($id);
        return response()->json($servico);
    }

    public function update(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'nome_prestador' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
        ]);

        $servico->update($request->all());

        return response()->json([
            'message' => 'Serviço atualizado com sucesso',
            'servico' => $servico
        ]);
    }

    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();

        return response()->json([
            'message' => 'Serviço excluído com sucesso'
        ]);
    }

    public function search(Request $request)
    {
        $query = Servico::query();

        if ($request->has('cidade')) {
            $query->where('cidade', 'like', '%' . $request->cidade . '%');
        }

        if ($request->has('bairro')) {
            $query->where('bairro', 'like', '%' . $request->bairro . '%');
        }

        if ($request->has('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        $servicos = $query->latest()->get();

        return response()->json($servicos);
    }
} 
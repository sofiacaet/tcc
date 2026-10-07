<?php

namespace App\Http\Controllers;

use App\Models\Orientacao;
use App\Models\Gestante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrientacaoController extends Controller
{
   public function index(Request $request)
    {
        Gate::authorize('viewAny', Orientacao::class);

        $user   = auth()->user();
        $roleId = $user->role_id;

        if ($roleId == 2) {
            // MÉDICO / COORDENADOR
            $gestantes = Gestante::orderBy('nome', 'asc')->get();
            
            // Pega a gestante selecionada na URL ou a primeira da lista
            $gestanteSelecionadaId = $request->get('gestante_id', $gestantes->first()?->id);
            $gestanteSelecionada   = $gestantes->where('id', $gestanteSelecionadaId)->first();

            // Carrega as mensagens da gestante selecionada
            $orientacoes = $gestanteSelecionada 
                ? Orientacao::with('user')->where('gestante_id', $gestanteSelecionada->id)->oldest()->get()
                : collect();

        } else {
            // GESTANTE
            $gestanteSelecionada = Gestante::where('email', $user->email)->first();
            $gestantes           = collect([$gestanteSelecionada]); // Apenas ela na lista
            
            $orientacoes = $gestanteSelecionada 
                ? Orientacao::with('user')->where('gestante_id', $gestanteSelecionada->id)->oldest()->get()
                : collect();
        }

        return view('orientacao.index', compact('orientacoes', 'gestantes', 'gestanteSelecionada'));
    }
    
    public function store(Request $request)
    {
        Gate::authorize('create', Orientacao::class);

        $request->validate([
            'mensagem' => 'required|string',
            'gestante_id' => 'required_if:role_id,2|nullable|exists:gestantes,id',
        ]);

        $user   = auth()->user();
        $roleId = $user->role_id;

        // Se for gestante, descobrimos o ID do perfil de gestante dela pelo e-mail
        if ($roleId != 2) {
            $gestante = Gestante::where('email', $user->email)->firstOrFail();
            $gestanteId = $gestante->id;
        } else {
            // Se for médico, pega a gestante selecionada no formulário
            $gestanteId = $request->gestante_id;
        }

        Orientacao::create([
            'gestante_id' => $gestanteId,
            'user_id'     => $user->id,
            'mensagem'    => $request->mensagem,
        ]);

        return redirect()->route('orientacao.index', ['gestante_id' => $gestanteId])
                         ->with('success', 'Mensagem enviada com sucesso!');
    }
}
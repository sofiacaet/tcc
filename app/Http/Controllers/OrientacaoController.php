<?php

namespace App\Http\Controllers;

use App\Models\Orientacao;
use App\Models\Gestante;
use App\Models\User; // <-- Adicionado para podermos buscar os usuários
use App\Notifications\NovaMensagemChat; // <-- Adicionado para chamar a notificação
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification; // <-- Adicionado para notificar múltiplos médicos de uma vez

class OrientacaoController extends Controller
{
   public function index(Request $request)
    {
        Gate::authorize('viewAny', Orientacao::class);

        $user   = auth()->user();
        $user->unreadNotifications()
             ->where('type', 'App\Notifications\NovaMensagemChat')
             ->update(['read_at' => now()]);
        $roleId = $user->role_id;

        // Inicializamos as variáveis para não dar erro no compact() da view
        $medicos = collect();
        $medicoSelecionado = null;
        $gestanteSelecionada = null;
        $gestantes = collect();

        if ($roleId == 2) {
            // MÉDICO / COORDENADOR
            $gestantes = Gestante::where('status', 'Em acompanhamento')->orderBy('nome', 'asc')->get();
            
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
            
            // ---> AQUI ESTÁ A CORREÇÃO: Buscando os médicos para a View da Gestante <---
            $medicos = User::where('role_id', 2)->orderBy('name', 'asc')->get();
            
            $medicoSelecionadoId = $request->get('medico_id', $medicos->first()?->id);
            $medicoSelecionado = $medicos->where('id', $medicoSelecionadoId)->first();

            // Como as mensagens são por "Gestante", puxamos as mensagens vinculadas a ela
            $orientacoes = $gestanteSelecionada 
                ? Orientacao::with('user')->where('gestante_id', $gestanteSelecionada->id)->oldest()->get()
                : collect();
        }

        // Adicionamos $medicos e $medicoSelecionado no compact
        return view('orientacao.index', compact('orientacoes', 'gestantes', 'gestanteSelecionada', 'medicos', 'medicoSelecionado'));
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

        // 1. Salva a mensagem no banco
        Orientacao::create([
            'gestante_id' => $gestanteId,
            'user_id'     => $user->id,
            'mensagem'    => $request->mensagem,
        ]);

        // =========================================================================
        // 2. DISPARO DE NOTIFICAÇÕES
        // =========================================================================
        if ($roleId == 2) {
            // O MÉDICO ENVIOU -> Notificar a conta de usuário da Gestante
            $gestanteDestino = Gestante::find($gestanteId);
            if ($gestanteDestino) {
                // Procura a conta de login (User) associada a essa gestante pelo email
                $usuarioGestante = User::where('email', $gestanteDestino->email)->first();
                if ($usuarioGestante) {
                    $usuarioGestante->notify(new NovaMensagemChat());
                }
            }
        } else {
            // A GESTANTE ENVIOU -> Notificar os Médicos/Coordenadores (role_id == 2)
            $medicos = User::where('role_id', 2)->get();
            // Notification::send manda a notificação para todos os usuários daquela lista (collection) de uma vez só
            Notification::send($medicos, new NovaMensagemChat());
        }
        // =========================================================================

        return redirect()->route('orientacao.index', ['gestante_id' => $gestanteId])
                         ->with('success', 'Mensagem enviada com sucesso!');
    }

   public function destroy(string $id)
    {
        $orientacao = Orientacao::findOrFail($id);

        // Valida na OrientacaoPolicy se o usuário tem permissão e se é o autor da mensagem
        Gate::authorize('delete', $orientacao);

        $gestanteId = $orientacao->gestante_id;
        $user = auth()->user();

        // =========================================================================
        // REMOVE A NOTIFICAÇÃO NÃO LIDA DO DESTINATÁRIO
        // =========================================================================
        if ($user->role_id == 2) {
            // Se o médico apagou, remove a notificação não lida da gestante
            $gestanteDestino = Gestante::find($gestanteId);
            if ($gestanteDestino) {
                $usuarioGestante = User::where('email', $gestanteDestino->email)->first();
                if ($usuarioGestante) {
                    $usuarioGestante->unreadNotifications()
                        ->where('type', 'App\Notifications\NovaMensagemChat')
                        ->latest()
                        ->first()
                        ?->delete();
                }
            }
        } else {
            // Se a gestante apagou, remove a notificação não lida dos médicos
            $medicos = User::where('role_id', 2)->get();
            foreach ($medicos as $medico) {
                $medico->unreadNotifications()
                    ->where('type', 'App\Notifications\NovaMensagemChat')
                    ->latest()
                    ->first()
                    ?->delete();
            }
        }
        // =========================================================================

        $orientacao->delete();

        if ($user->role_id == 2) {
            return redirect()->route('orientacao.index', ['gestante_id' => $gestanteId])
                             ->with('success', 'Mensagem excluída com sucesso!');
        }

        return redirect()->route('orientacao.index')
                         ->with('success', 'Mensagem excluída com sucesso!');
    }
}
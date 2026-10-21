<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestante;
use App\Models\Consulta;
use App\Models\Exame;
use App\Models\Orientacao; // <-- Adicionado
use Carbon\Carbon;         // <-- Adicionado

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // =========================================================
        // PAINEL DO MÉDICO / COORDENADOR
        // =========================================================
        if ($user->role_id == 2) {
            $totalGestantes = Gestante::where('status', 'Em acompanhamento')->count();
            $consultasAgendadas = Consulta::where('status', 'Agendada')->count();
            $examesRecebidos = Exame::where('status', 'Recebido')->count();

            // Novidade: Busca as consultas agendadas para HOJE
            $consultasHoje = Consulta::with('gestante')
                                     ->where('status', 'Agendada')
                                     ->whereDate('data', Carbon::today())
                                     ->orderBy('horario', 'asc')
                                     ->take(5)->get();

            // Novidade: Busca os últimos 5 exames que as pacientes enviaram
            $ultimosExames = Exame::with('gestante')
                                  ->where('status', 'Recebido')
                                  ->orderBy('updated_at', 'desc')
                                  ->take(5)->get();

            return view('home', compact('totalGestantes', 'consultasAgendadas', 'examesRecebidos', 'consultasHoje', 'ultimosExames'));
        } 
        // =========================================================
        // PAINEL DA GESTANTE
        // =========================================================
        else {
            $gestante = Gestante::where('email', $user->email)->first();
            
            $proximaConsulta = $gestante 
                ? Consulta::where('gestante_id', $gestante->id)
                          ->where('status', 'Agendada')
                          ->whereDate('data', '>=', Carbon::today())
                          ->orderBy('data', 'asc')->first() 
                : null;
                
            $examesPendentes = $gestante 
                ? Exame::where('gestante_id', $gestante->id)->where('status', 'Solicitado')->count() 
                : 0;

            // Novidade: Puxa a última mensagem que a equipe médica mandou para ela no chat
            $ultimaOrientacao = $gestante 
                ? Orientacao::with('user')
                            ->where('gestante_id', $gestante->id)
                            ->whereHas('user', function($q) {
                                $q->where('role_id', 2); // Apenas mensagens de médicos
                            })->latest()->first() 
                : null;

            return view('home', compact('gestante', 'proximaConsulta', 'examesPendentes', 'ultimaOrientacao'));
        }
    }
}
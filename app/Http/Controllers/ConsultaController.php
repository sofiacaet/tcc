<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Gestante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Consulta::class);

    if (auth()->user()->role_id == 2) {
        // Coordenador vê tudo, mas separado por status
        $agendadas = Consulta::where('status', 'Agendada')->get();
        $realizadas = Consulta::where('status', 'Realizada')->get();
    } else {
        // Professor vê apenas o dele, separado por status
        $email = auth()->user()->email;
        
        $agendadas = Consulta::where('status', 'Agendada')
            ->whereHas('gestante', function ($q) use ($email) {
                $q->where('email', $email);
            })->get();

        $realizadas = Consulta::where('status', 'Realizada')
            ->whereHas('gestante', function ($q) use ($email) {
                $q->where('email', $email);
            })->get();
    }

    return view('consulta.index', compact('agendadas', 'realizadas'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Consulta::class);
        $gestantes = Gestante::all();
        return view('consulta.create', compact('gestantes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Consulta::class);
        $gestante = Gestante::find($request->gestante);

        if(isset($gestante)) {
            $consulta = new Consulta();
            $consulta->tipo_consulta = mb_strtoupper($request->tipo_consulta, 'UTF-8');
            $consulta->data = $request->data;
            $consulta->horario = $request->horario;
            
            $consulta->gestante()->associate($gestante);
            $consulta->save();
        }
        return redirect()->route('consulta.index');
    }

        /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $consulta = Consulta::with('gestante')->find($id);
        
        // Altere para a Policy correspondente se necessário (ex: view)
        Gate::authorize('view', $consulta); 

        if(isset($consulta)) {
            return view('consulta.show', compact('consulta'));
        }
        
        return redirect()->route('consulta.index');
    }
        


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $consulta = Consulta::find($id);
        Gate::authorize('update', $consulta);

        if(isset($consulta)) {
            $gestantes = Gestante::all();
            return view('consulta.edit', compact(['consulta', 'gestantes']));
        }
        return redirect()->route('consulta.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $consulta = Consulta::find($id);
    Gate::authorize('update', $consulta);

    if(isset($consulta)) {
        // Atualiza e salva os novos dados clínicos informados no registro
        $consulta->peso_atual = $request->peso_atual;
        $consulta->pressao_arterial = $request->pressao_arterial;
        $consulta->batimentos_fetais = $request->batimentos_fetais;
        $consulta->evolucao_clinica = $request->evolucao_clinica;
        
        // Altera o status mudando de Agendada para Realizada
        $consulta->status = 'Realizada';
        
        $consulta->save();
    }

    return redirect()->route('consulta.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consulta = Consulta::find($id);
        Gate::authorize('delete', $consulta);
        if(isset($consulta)){
            $consulta->delete();
        }

        return redirect()->route('consulta.index');
    }


    /**
     * Report - PDF
     */
    public function report(){
        // COORDENADOR = role_id 2 → vê todas as consultas do sistema
        if (auth()->user()->role_id == 2) {
            $consultas = Consulta::with('gestante')->get();
        } 
        // PROFESSOR = role_id 1 → vê apenas as consultas das suas próprias gestantes
        else {
            $email = auth()->user()->email;
            $consultas = Consulta::with('gestante')
                ->whereHas('gestante', function ($q) use ($email) {
                    $q->where('email', $email);
                })->get();
        }

        // Carrega a view do relatório passando a lista filtrada de consultas
        $pdf = Pdf::loadView('consulta.report', compact('consultas'));

        // Abre o PDF diretamente no navegador do usuário
        return $pdf->stream('Relatorio_Consultas.pdf');
    }
}

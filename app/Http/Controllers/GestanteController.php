<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestante;
use App\Models\Consulta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class GestanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        Gate::authorize('viewAny', Gestante::class);

        // COORDENADOR = role_id 2 → vê todos, ordenado alfabeticamente
        if (auth()->user()->role_id == 2) {
            $gestantes = Gestante::orderBy('nome', 'asc')->get();
        } 
        // PROFESSOR = role_id 1 → vê somente o gestante com o mesmo email do login, ordenado alfabeticamente
        else {
            $email = auth()->user()->email;
            $gestantes = Gestante::where('email', $email)->orderBy('nome', 'asc')->get();
        }

        return view('gestante.index', compact('gestantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Gestante::class);
        return view('gestante.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Gestante::class);

        $request->validate([
            'cpf' => 'nullable|max:14',
        ]);


            $gestante = new Gestante();
            $gestante->nome = mb_strtoupper($request->nome, 'UTF-8');
            $gestante->email = $request->email;
            $gestante->telefone = $request->telefone;
            $gestante->altura = $request->altura;
            $gestante->data_nascimento = $request->data_nascimento;
            $gestante->cpf = $request->cpf;
            $gestante->estado_civil = $request->estado_civil;
            $gestante->peso_atual = $request->peso_atual;
            $gestante->status = 'Em acompanhamento';
            $gestante->save();

            if($request->hasFile('foto')) {
                // Upload File
                $extensao_arq = $request->file('foto')->getClientOriginalExtension();
                $name = $gestante->id.'_'.time().'.'.$extensao_arq;
                $request->file('foto')->storeAs('fotos', $name, ['disk' => 'public']);
                $gestante->foto = 'fotos/'.$name;
                $gestante->save();
            }
        

        return redirect()->route('gestante.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. Busca a gestante específica no banco de dados
        $gestante = Gestante::findOrFail($id);
        
        // 2. Passa a VARIÁVEL $gestante para a Policy avaliar se o usuário pode vê-la
        Gate::authorize('view', $gestante);

        // 3. Retorna a tela enviando os dados da paciente
        return view('gestante.show', compact('gestante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gestante = Gestante::find($id);
        Gate::authorize('update', $gestante);

        if(isset($gestante)) {
            return view('gestante.edit', compact(['gestante']));
        }

        return redirect()->route('gestante.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gestante = Gestante::find($id);
        Gate::authorize('update', $gestante);

        $request->validate([
            'cpf' => 'nullable|max:14',
        ]);

       
            $gestante->nome = mb_strtoupper($request->nome, 'UTF-8');
            $gestante->email = $request->email;
            $gestante->telefone = $request->telefone;
            $gestante->altura = $request->altura;
            $gestante->data_nascimento = $request->data_nascimento;
            $gestante->cpf = $request->cpf;
            $gestante->estado_civil = $request->estado_civil;
            $gestante->peso_atual = $request->peso_atual;
            if($request->has('status')){
            $gestante->status = $request->status;
        }
            

            if($request->hasFile('foto')) {
                // Upload File
                $extensao_arq = $request->file('foto')->getClientOriginalExtension();
                $name = $gestante->id.'_'.time().'.'.$extensao_arq;
                $request->file('foto')->storeAs('fotos', $name, ['disk' => 'public']);
                $gestante->foto = 'fotos/'.$name;
            }
            $gestante->save();


        return redirect()->route('gestante.index');
    }

   public function updateStatus(Request $request, $id)
    {
        $gestante = Gestante::findOrFail($id);
        Gate::authorize('update', $gestante);
        
        // Garante que o status e o motivo venham corretamente
        $request->validate([
            'status' => 'required|in:Em acompanhamento,Arquivada',
            'motivo_arquivamento' => 'required_if:status,Arquivada|nullable|string|max:255',
        ]);

        $gestante->status = $request->status;

        if ($request->status === 'Arquivada') {
            $gestante->motivo_arquivamento = $request->motivo_arquivamento;
        } else {
            // Se for reativada, limpa o motivo
            $gestante->motivo_arquivamento = null;
        }
        
        $gestante->save();

        // Redireciona de volta para a tela principal (sem filtro de URL)
        return redirect()->route('gestante.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gestante = Gestante::find($id);
        Gate::authorize('delete', $gestante);

        if(isset($gestante)) {
            $gestante->delete();
        }

        return redirect()->route('gestante.index');
    }

    public function report() {
         // COORDENADOR vê todos
    if (auth()->user()->role_id == 2) {
        $gestantes = Gestante::with('consultas')->get();
    } 
    // PROFESSOR vê somente seu próprio gestante
    else {
        $email = auth()->user()->email;
        $gestantes = Gestante::with('consultas')
            ->where('email', $email)
            ->get();
    }

    $pdf = Pdf::loadView('gestante.report', ['gestantes' => $gestantes]);

    return $pdf->stream('document.pdf');



        
}
}
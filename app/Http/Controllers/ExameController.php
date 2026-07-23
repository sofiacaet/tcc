<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exame;
use App\Models\Gestante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class ExameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        Gate::authorize('viewAny', Exame::class);

        $roleId = auth()->user()->role_id;
        $email  = auth()->user()->email;

        if ($roleId == 2) {
            // Coordenador / Médico vê todos os exames do sistema, separados por status
            $solicitados = Exame::where('status', 'Solicitado')->get();
            $recebidos   = Exame::where('status', 'Recebido')->get();
        } else {
            // Gestante / Professor vê apenas os exames vinculados ao seu e-mail
            $solicitados = Exame::where('status', 'Solicitado')
                ->whereHas('gestante', function ($q) use ($email) {
                    $q->where('email', $email);
                })->get();

            $recebidos = Exame::where('status', 'Recebido')
                ->whereHas('gestante', function ($q) use ($email) {
                    $q->where('email', $email);
                })->get();
        }

        return view('exame.index', compact('solicitados', 'recebidos'));
    }


        public function uploadDocumento(Request $request, $id)
    {
        $exame = Exame::findOrFail($id);

        if ($request->hasFile('documento')) {
            $extensao_arq = $request->file('documento')->getClientOriginalExtension();
            $name = $exame->id . '_' . time() . '.' . $extensao_arq;
            
            $request->file('documento')->storeAs('documentos', $name, ['disk' => 'public']);
            
            // Ao salvar o arquivo, altera o documento e MUDAR O STATUS para 'Recebido'
            $exame->documento = 'documentos/' . $name;
            $exame->status = 'Recebido'; // <--- AQUI! Removido a marcação de comentário (//)
            $exame->save();
        }

        return redirect()->back()->with('success', 'Exame enviado com sucesso!');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Exame::class);
        $gestantes = Gestante::all();
        return view('exame.create', compact('gestantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Exame::class);
        $gestante = Gestante::find($request->gestante);

        if(isset($gestante)) {
            $exame = new Exame();
            $exame->tipo_exame = mb_strtoupper($request->tipo_exame, 'UTF-8');
            $exame->status = 'Solicitado';
            $exame->gestante()->associate($gestante);
            $exame->save();

            
        }

        return redirect()->route('exame.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('view', Exame::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $exame = Exame::find($id);
        Gate::authorize('update', $exame);

        if(isset($exame)) {
            $gestantes = Gestante::all();
            return view('exame.edit', compact(['exame', 'gestantes']));
        }

        return redirect()->route('exame.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $exame = Exame::find($id);
        Gate::authorize('update', $exame);
        $gestante = Gestante::find($request->gestante);

        if(isset($gestante) && isset($exame)) {
            $exame->tipo_exame = mb_strtoupper($request->tipo_exame, 'UTF-8');
           
            $exame->gestante()->associate($gestante);

            
            $exame->save();
        }

        return redirect()->route('exame.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exame = Exame::find($id);
        Gate::authorize('delete', $exame);

        if(isset($exame)) {
            $exame->delete();
        }

        return redirect()->route('exame.index');
    }

    public function report() {
         // COORDENADOR vê todos
        if (auth()->user()->role_id == 2) {
            $exames = Exame::with('gestante')->get();
        } 
        // PROFESSOR vê somente seu próprio gestante
        else {
            $email = auth()->user()->email;
            $exames = Exame::with('gestante')
            ->whereHas('gestante', function ($q) use ($email) {
            $q->where('email', $email);
            })
            ->get();
        }

        $pdf = Pdf::loadView('exame.report', ['exames' => $exames]);

        return $pdf->stream('document.pdf');
    }
}
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

        // COORDENADOR = role_id 2 → vê todos
        if (auth()->user()->role_id == 2) {
            $gestantes = Gestante::all();
        } 
        // PROFESSOR = role_id 1 → vê somente o gestante com o mesmo email do login
        else {
            $email = auth()->user()->email;
            $gestantes = Gestante::where('email', $email)->get();
        }

        return view('gestante.index', compact('gestantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Gestante::class);
        $consultas = Consulta::all();
        return view('gestante.create', compact('consultas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Gestante::class);
        $consulta = Consulta::find($request->consulta);

        if(isset($consulta)) {
            $gestante = new Gestante();
            $gestante->nome = mb_strtoupper($request->nome, 'UTF-8');
            $gestante->email = $request->email;
            $gestante->telefone = $request->telefone;
            $gestante->altura = $request->altura;
            $gestante->idade = $request->idade;
            $gestante->peso_atual = $request->peso_atual;
            $gestante->consulta()->associate($consulta);
            $gestante->save();

            if($request->hasFile('foto')) {
                // Upload File
                $extensao_arq = $request->file('foto')->getClientOriginalExtension();
                $name = $gestante->id.'_'.time().'.'.$extensao_arq;
                $request->file('foto')->storeAs('fotos', $name, ['disk' => 'public']);
                $gestante->foto = 'fotos/'.$name;
                $gestante->save();
            }
        }

        return redirect()->route('gestante.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('view', Gestante::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gestante = Gestante::find($id);
        Gate::authorize('update', $gestante);

        if(isset($gestante)) {
            $consultas = Consulta::all();
            return view('gestante.edit', compact(['gestante', 'consultas']));
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
        $consulta = Consulta::find($request->consulta);

        if(isset($consulta) && isset($gestante)) {
            $gestante->nome = mb_strtoupper($request->nome, 'UTF-8');
            $gestante->email = $request->email;
            $gestante->telefone = $request->telefone;
            $gestante->altura = $request->altura;
            $gestante->idade = $request->idade;
            $gestante->peso_atual = $request->peso_atual;
            $gestante->consulta()->associate($consulta);

            if($request->hasFile('foto')) {
                // Upload File
                $extensao_arq = $request->file('foto')->getClientOriginalExtension();
                $name = $gestante->id.'_'.time().'.'.$extensao_arq;
                $request->file('foto')->storeAs('fotos', $name, ['disk' => 'public']);
                $gestante->foto = 'fotos/'.$name;
            }
            $gestante->save();
        }

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
        $gestantes = Gestante::with('consulta')->get();
    } 
    // PROFESSOR vê somente seu próprio gestante
    else {
        $email = auth()->user()->email;
        $gestantes = Gestante::with('consulta')
            ->where('email', $email)
            ->get();
    }

    $pdf = Pdf::loadView('gestante.report', ['gestantes' => $gestantes]);

    return $pdf->stream('document.pdf');



        
}
}
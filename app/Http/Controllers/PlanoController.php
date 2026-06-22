<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;
use App\Models\Gestante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class PlanoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Plano::class);

        // COORDENADOR = role_id 2 → vê todos
        if (auth()->user()->role_id == 2) {
            $planos = Plano::all();
        } 
        // PROFESSOR = role_id 1 → vê somente o gestante com o mesmo email do login
        else {
            $email = auth()->user()->email;
            $planos = Plano::whereHas('gestante', function ($q) use ($email) {
            $q->where('email', $email);
            })->get();
        }

        return view('plano.index', compact('planos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Plano::class);
        $gestantes = Gestante::all();
        return view('plano.create', compact('gestantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Plano::class);
        $gestante = Gestante::find($request->gestante);

        if(isset($gestante)) {
            $plano = new Plano();
            $plano->nome = mb_strtoupper($request->nome, 'UTF-8');
            $plano->kcal_dia = $request->kcal_dia;
            $plano->ref_dia = $request->ref_dia;
            $plano->observacoes = $request->observacoes;
           
            $plano->gestante()->associate($gestante);
            $plano->save();

            
        }

        return redirect()->route('plano.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('view', Plano::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plano = Plano::find($id);
        Gate::authorize('update', $plano);

        if(isset($plano)) {
            $gestantes = Gestante::all();
            return view('plano.edit', compact(['plano', 'gestantes']));
        }

        return redirect()->route('plano.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plano = Plano::find($id);
        Gate::authorize('update', $plano);
        $gestante = Gestante::find($request->gestante);

        if(isset($gestante) && isset($plano)) {
            $plano->nome = mb_strtoupper($request->nome, 'UTF-8');
            $plano->kcal_dia = $request->kcal_dia;
            $plano->ref_dia = $request->ref_dia;
            $plano->observacoes = $request->observacoes;
           
            $plano->gestante()->associate($gestante);

            
            $plano->save();
        }

        return redirect()->route('plano.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plano = Plano::find($id);
        Gate::authorize('delete', $plano);

        if(isset($plano)) {
            $plano->delete();
        }

        return redirect()->route('plano.index');
    }

    public function report() {
         // COORDENADOR vê todos
    if (auth()->user()->role_id == 2) {
        $planos = Plano::with('gestante')->get();
    } 
    // PROFESSOR vê somente seu próprio gestante
    else {
        $email = auth()->user()->email;
        $planos = Plano::with('gestante')
        ->whereHas('gestante', function ($q) use ($email) {
        $q->where('email', $email);
        })
        ->get();
    }

    $pdf = Pdf::loadView('plano.report', ['planos' => $planos]);

    return $pdf->stream('document.pdf');



        
}
}
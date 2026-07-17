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

        // COORDENADOR = role_id 2 → vê todos
        if (auth()->user()->role_id == 2) {
            $exames = Exame::all();
        } 
        // PROFESSOR = role_id 1 → vê somente o gestante com o mesmo email do login
        else {
            $email = auth()->user()->email;
            $exames = Exame::whereHas('gestante', function ($q) use ($email) {
            $q->where('email', $email);
            })->get();
        }

        return view('exame.index', compact('exames'));
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
            $exame->nome = mb_strtoupper($request->nome, 'UTF-8');
            $exame->kcal_dia = $request->kcal_dia;
            $exame->ref_dia = $request->ref_dia;
            $exame->observacoes = $request->observacoes;
           
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
            $exame->nome = mb_strtoupper($request->nome, 'UTF-8');
            $exame->kcal_dia = $request->kcal_dia;
            $exame->ref_dia = $request->ref_dia;
            $exame->observacoes = $request->observacoes;
           
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
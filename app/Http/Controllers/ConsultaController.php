<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
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
        $consultas = Consulta::all();
        return view('consulta.index', compact('consultas'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('consulta.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $consulta = new Consulta();
        $consulta->nome = mb_strtoupper($request->nome, 'UTF-8');
        $consulta->objetivo = $request->objetivo;
        $consulta->save();

        return redirect()->route('consulta.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $consulta = Consulta::find($id);

        if(isset($consulta)) {
            return view('consulta.edit', compact('consulta'));
        }
        return redirect()->route('consulta.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $consulta = Consulta::find($id);

        if(isset($consulta)) {
            $consulta->nome = mb_strtoupper($request->nome, 'UTF-8');
            $consulta->objetivo = $request->objetivo;
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
        if(isset($consulta)){
            $consulta->delete();
        }

        return redirect()->route('consulta.index');
    }

    /**
     * Report - PDF
     */
    public function report()
    {
        $consultas = Consulta::all();
        $pdf = Pdf::loadView('consulta.report', compact('consultas'));

        return $pdf->stream('Relatorio_Consultas.pdf');
        // return $pdf->download('Relatorio_Cursos.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gestante;
use App\Models\Consulta;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class GestanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Gestante::class);

        // COORDENADOR/MÉDICO = role_id 2 → vê todos em formato de tabela
        if (auth()->user()->role_id == 2) {
            $gestantes = Gestante::orderBy('nome', 'asc')->get();
            
            return view('gestante.index', compact('gestantes'));
        } 
        // GESTANTE = role_id 1 → vê somente o seu próprio perfil
        else {
            $email = auth()->user()->email;
            
            // Busca apenas o perfil correspondente ao e-mail logado
            $gestante = Gestante::where('email', $email)->first();

            return view('gestante.show', compact('gestante'));
        }
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
            'nome'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf'   => 'nullable|max:14',
            'dum'   => 'required|date|before_or_equal:today',
        ]);

        // 1. A transação agora RETORNA o usuário criado
        $user = DB::transaction(function () use ($request) {
            $nomeFormatado = mb_strtoupper($request->nome, 'UTF-8');

            $user = User::create([
                'name'     => $nomeFormatado,
                'email'    => $request->email,
                'password' => Hash::make(Str::random(16)),
                'role_id'  => 1,
            ]);

            $gestante = new Gestante();
            $gestante->nome = $nomeFormatado;
            $gestante->email = $request->email;
            $gestante->dum = $request->dum;
            $gestante->telefone = $request->telefone;
            $gestante->altura = $request->altura;
            $gestante->data_nascimento = $request->data_nascimento;
            $gestante->cpf = $request->cpf;
            $gestante->estado_civil = $request->estado_civil;
            $gestante->peso_atual = $request->peso_atual;
            $gestante->status = 'Em acompanhamento';
            $gestante->save();

            if ($request->hasFile('foto')) {
                $extensao_arq = $request->file('foto')->getClientOriginalExtension();
                $name = $gestante->id . '_' . time() . '.' . $extensao_arq;
                $request->file('foto')->storeAs('fotos', $name, ['disk' => 'public']);
                $gestante->foto = 'fotos/' . $name;
                $gestante->save();
            }

            // Retorna o $user para a variável fora do DB::transaction
            return $user; 
        });

        // 2. FORA DA TRANSAÇÃO: O banco de dados já salvou tudo e está seguro.
        // Agora tentamos enviar o e-mail.
        try {
            Password::sendResetLink(['email' => $user->email]);
            
            return redirect()->route('gestante.index')
                ->with('success', 'Gestante cadastrada e e-mail de acesso enviado com sucesso!');
                
        } catch (\Exception $e) {
            // Se o e-mail falhar, registramos o erro no log para o programador ver (storage/logs/laravel.log)
            \Illuminate\Support\Facades\Log::error('Erro ao enviar e-mail de senha para gestante: ' . $e->getMessage());
            
            // Mas redirecionamos com sucesso, avisando que o cadastro foi feito, 
            // apenas o e-mail que precisará ser reenviado depois.
            return redirect()->route('gestante.index')
                ->with('warning', 'Gestante cadastrada com sucesso no banco, mas houve uma instabilidade ao enviar o e-mail. Peça para a gestante usar a opção "Esqueci minha senha" no login.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gestante = Gestante::findOrFail($id);
        
        Gate::authorize('view', $gestante);

        return view('gestante.show', compact('gestante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gestante = Gestante::find($id);
        Gate::authorize('update', $gestante);

        if (isset($gestante)) {
            return view('gestante.edit', compact('gestante'));
        }

        return redirect()->route('gestante.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gestante = Gestante::findOrFail($id);
        Gate::authorize('update', $gestante);

        // Identifica o ID do usuário correspondente para ignorar a regra 'unique' ao editar
        $user = User::where('email', $gestante->email)->first();

     

        // 2. Monta as regras do e-mail de forma condicional
        $regrasEmail = ['required', 'email'];
        if ($user) {
            $regrasEmail[] = Rule::unique('users', 'email')->ignore($user->id);
        } else {
            $regrasEmail[] = 'unique:users,email';
        }

        // 3. Aplica a validação
        $request->validate([
            'nome'  => 'required|string|max:255',
            'email' => $regrasEmail,
            'cpf'   => 'nullable|max:14',
            'dum'   => 'required|date|before_or_equal:today',
        ]);

        DB::transaction(function () use ($request, $gestante, $user) {
            $oldEmail = $gestante->email;

            $gestante->nome = mb_strtoupper($request->nome, 'UTF-8');
            $gestante->email = $request->email;
            $gestante->dum = $request->dum;
            $gestante->telefone = $request->telefone;
            $gestante->altura = $request->altura;
            $gestante->data_nascimento = $request->data_nascimento;
            $gestante->cpf = $request->cpf;
            $gestante->estado_civil = $request->estado_civil;
            $gestante->peso_atual = $request->peso_atual;
            
            if ($request->has('status')) {
                $gestante->status = $request->status;
            }

            if ($request->hasFile('foto')) {
                $extensao_arq = $request->file('foto')->getClientOriginalExtension();
                $name = $gestante->id . '_' . time() . '.' . $extensao_arq;
                $request->file('foto')->storeAs('fotos', $name, ['disk' => 'public']);
                $gestante->foto = 'fotos/' . $name;
            }
            
            $gestante->save();

            // Mantém os dados da conta 'users' atualizados caso nome ou e-mail mudem
            if ($user) {
                $user->name = $gestante->nome;
                $user->email = $gestante->email;
                $user->save();
            }
        });

        return redirect()->route('gestante.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $gestante = Gestante::findOrFail($id);
        Gate::authorize('update', $gestante);
        
        $request->validate([
            'status' => 'required|in:Em acompanhamento,Arquivada',
            'motivo_arquivamento' => 'required_if:status,Arquivada|nullable|string|max:255',
        ]);

        $gestante->status = $request->status;

        if ($request->status === 'Arquivada') {
            $gestante->motivo_arquivamento = $request->motivo_arquivamento;
        } else {
            $gestante->motivo_arquivamento = null;
        }
        
        $gestante->save();

        return redirect()->route('gestante.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gestante = Gestante::find($id);
        Gate::authorize('delete', $gestante);

        if (isset($gestante)) {
            // Remove também o usuário associado para não deixar registros órfãos
            User::where('email', $gestante->email)->delete();
            $gestante->delete();
        }

        return redirect()->route('gestante.index');
    }

    public function report() 
    {
        if (auth()->user()->role_id == 2) {
            $gestantes = Gestante::with('consultas')->get();
        } else {
            $email = auth()->user()->email;
            $gestantes = Gestante::with('consultas')
                ->where('email', $email)
                ->get();
        }

        $pdf = Pdf::loadView('gestante.report', ['gestantes' => $gestantes]);

        return $pdf->stream('document.pdf');
    }
}
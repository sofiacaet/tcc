<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Gestante extends Model
{
    use SoftDeletes;

    // AQUI: Liberamos os campos para serem salvos, INCLUINDO o 'status'
    protected $fillable = [
        'nome', 
        'email', 
        'dum',
        'telefone', 
        'altura', 
        'data_nascimento', 
        'cpf', 
        'estado_civil', 
        'peso_atual',
        'status', // <-- Nosso novo campo adicionado aqui!
        'motivo_arquivamento',
        'foto',
    ];

    protected $casts = [
        'dum' => 'date',
    ];

    protected static function booted()
    {
        static::deleting(function ($gestante) {
            // Se você usar forceDelete() na gestante, apaga os exames do banco de vez
            if ($gestante->isForceDeleting()) {
                $gestante->exames()->forceDelete();
                $gestante->consultas()->forceDelete();
            } else {
                // Ao deletar a gestante (Soft Delete), os exames vão para a lixeira junto
                $gestante->exames()->delete();
                $gestante->consultas()->delete();
            }
        });
    }

    public function consultas() {
        return $this->hasMany('\App\Models\Consulta', 'gestante_id');
    }

    public function exames() {
        return $this->hasMany('\App\Models\Exame', 'gestante_id');
    }

    public function getInfoGestacaoAttribute()
    {
        if (!$this->dum) {
            return null;
        }

        $dum = Carbon::parse($this->dum);
        $hoje = Carbon::today();

        if ($dum->isFuture()) {
            return null;
        }

        $diasTotais = $dum->diffInDays($hoje);
        $semanas = (int) floor($diasTotais / 7);
        $dias = (int) ($diasTotais % 7);

        // Define o trimestre
        if ($semanas < 14) {
            $trimestre = '1º trimestre';
        } elseif ($semanas < 28) {
            $trimestre = '2º trimestre';
        } else {
            $trimestre = '3º trimestre';
        }

        // Progresso em % (baseado nas 40 semanas / 280 dias padrão)
        $progresso = min(100, round(($diasTotais / 280) * 100));

        $textoSemana = "Semana {$semanas}";
        $textoDias = $dias > 0 ? " + {$dias} " . ($dias == 1 ? 'dia' : 'dias') : '';

        return [
            'semanas' => $semanas,
            'dias' => $dias,
            'texto_curto' => $textoSemana,
            'texto_completo' => "{$textoSemana}{$textoDias}",
            'trimestre' => $trimestre,
            'progresso' => $progresso,
        ];
    }
}
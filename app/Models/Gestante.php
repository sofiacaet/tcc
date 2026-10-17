<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestante extends Model
{
    use SoftDeletes;

    // AQUI: Liberamos os campos para serem salvos, INCLUINDO o 'status'
    protected $fillable = [
        'nome', 
        'email', 
        'telefone', 
        'altura', 
        'data_nascimento', 
        'cpf', 
        'estado_civil', 
        'peso_atual',
        'status', // <-- Nosso novo campo adicionado aqui!
        'motivo_arquivamento'
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
}
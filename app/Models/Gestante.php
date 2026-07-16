<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Gestante extends Model
{
    use SoftDeletes;

    protected static function booted()
    {
        static::deleting(function ($gestante) {
            // Se você usar forceDelete() na gestante, apaga os exames do banco de vez
            if ($gestante->isForceDeleting()) {
                $gestante->exames()->forceDelete();
            } else {
                // Ao deletar a gestante (Soft Delete), os exames vão para a lixeira junto
                $gestante->exames()->delete();
            }
        });
    }

    public function consulta() {
        return $this->belongsTo('\App\Models\Consulta');
    }

     public function exames() {
        return $this->hasMany('\App\Models\Exame', 'gestante_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orientacao extends Model
{
    use HasFactory;

    protected $table = 'orientacoes';

    protected $fillable = [
        'gestante_id',
        'user_id',
        'mensagem',
    ];

    // Relacionamento com a Gestante
    public function gestante()
    {
        return $this->belongsTo(Gestante::class);
    }

    // Relacionamento com o Autor da mensagem (Usuário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    use SoftDeletes;

    public function gestante() {
        return $this->belongsTo('\App\Models\Gestante');
    }
}

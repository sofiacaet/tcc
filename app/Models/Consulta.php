<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gestante;


use \Illuminate\Database\Eloquent\SoftDeletes;
class Consulta extends Model {
use SoftDeletes;
public function gestante() {
return $this->hasMany('\App\Models\Gestante');
}
}

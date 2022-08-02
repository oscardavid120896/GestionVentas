<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoProfesor extends Model
{
    use HasFactory;

    protected $table = "grupoProfesor";
    protected $primaryKey = 'id';

    protected $fillable = [
        'idGrupo',
        'idProfesor',
        'idMateria'
    ];
}

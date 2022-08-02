<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Alumno extends Model
{
    use HasFactory;

    protected $table = "alumno";
    protected $primaryKey = 'id';

    protected $fillable = [
        'idGrupo',
        'idUsuario',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Materia extends Model
{
    use HasFactory;

    protected $table = "materia";
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'unidades',
        'cuatrimestre',
    ];
}

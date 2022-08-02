<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Profesor extends Model
{
    use HasFactory;

    protected $table = "profesor";
    protected $primaryKey = 'id';

    protected $fillable = [
        'cedula',
        'idUsuario',
    ];

}

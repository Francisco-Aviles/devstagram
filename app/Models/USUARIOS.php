<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class USUARIOS extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'usuario',
        'contrasena',
        'contrasena_confirm'
    ];
    protected $primaryKey = 'id';

    // public $timestamps = false;

    
}

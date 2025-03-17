<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    //
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];

    public function user()
    {
        //relacion inversa para saber que usario realizo el comentario
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'subtitulo',
        'texto',
        'imagen',
        'cover',
        'user_id',
        'categoria_id',
    ];

}

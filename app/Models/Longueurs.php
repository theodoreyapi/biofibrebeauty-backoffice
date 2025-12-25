<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Longueurs extends Model
{
    protected $fillable = [
        'valeur_longueur',
        'statut_longueur',
    ];

    protected $table = 'longueurs';

    protected $primaryKey = 'id_longueur';
}

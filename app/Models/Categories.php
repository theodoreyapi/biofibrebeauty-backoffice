<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'nom_categorie',
        'statut_categorie',
    ];

    protected $table = 'categories';

    protected $primaryKey = 'id_categorie';
}

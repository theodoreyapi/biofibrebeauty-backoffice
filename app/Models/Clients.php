<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'nom_complet',
        'telephone',
        'statut_client',
    ];

    protected $table = 'clients';

    protected $primaryKey = 'id_client';
}

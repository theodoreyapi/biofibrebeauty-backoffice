<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    protected $fillable = [
        'montant_paiement',
        'mode_paiement',
        'statut_paiement',
        'commande_id',
    ];

    protected $table = 'paiements';

    protected $primaryKey = 'id_paiement';

     public function commande()
    {
        return $this->belongsTo(Commandes::class, 'commande_id', 'id_commande');
    }
}

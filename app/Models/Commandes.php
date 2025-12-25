<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commandes extends Model
{
    protected $fillable = [
        'montant_livraison',
        'montant_produit',
        'adresse_livraison',
        'zone',
        'mode_paiement',
        'quantite',
        'prix_unitaire',
        'statut_commande',
        'client_id',
        'produit_id',
    ];

    protected $table = 'commandes';

    protected $primaryKey = 'id_commande';

    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id_client');
    }

    public function paiement()
    {
        return $this->hasOne(Paiements::class, 'commande_id', 'id_commande');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    protected $fillable = [
        'image_produit',
        'nom_produit',
        'couleur_produit',
        'description_produit',
        'prix_produit',
        'stock_produit',
        'statut_produit',
        'categorie_id',
        'longueur_id',
    ];

    protected $table = 'produits';

    protected $primaryKey = 'id_produit';
}

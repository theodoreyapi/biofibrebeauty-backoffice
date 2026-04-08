<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitImage extends Model
{
    protected $table = 'produit_image';

    protected $primaryKey = 'id_produit_image';
    
    protected $fillable = ['image_produit', 'produit_id'];
}

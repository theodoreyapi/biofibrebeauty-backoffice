<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id('id_produit')->primary();
            $table->string('image_produit');
            $table->string('nom_produit');
            $table->string('couleur_produit');
            $table->text('description_produit')->nullable();
            $table->decimal('prix_produit', 10, 2);
            $table->integer('stock_produit');
            $table->string('statut_produit')->default('active')->comment('active, inactive');
            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')->references('id_categorie')->on('categories');
            $table->unsignedBigInteger('longueur_id');
            $table->foreign('longueur_id')->references('id_longueur')->on('longueurs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
        Schema::table('produits', function (Blueprint $table) {
            $table->dropForeign(['categorie_id', 'longueur_id']);
            $table->dropColumn('categorie_id');
            $table->dropColumn('longueur_id');
        });
    }
};

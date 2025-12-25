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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('id_commande')->primary();
            $table->decimal('montant_livraison', 10, 2);
            $table->decimal('montant_produit', 10, 2);
            $table->decimal('prix_unitaire', 10, 2);
            $table->integer('quantite');
            $table->string('adresse_livraison')->nullable();
            $table->string('zone')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('statut_commande')->default('pending')->comment('pending, completed, cancelled');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id_client')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('produit_id');
            $table->foreign('produit_id')->references('id_produit')->on('produits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign(['produit_id', 'client_id']);
            $table->dropColumn('produit_id');
            $table->dropColumn('client_id');
        });
    }
};

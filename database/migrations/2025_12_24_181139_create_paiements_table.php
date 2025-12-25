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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('id_paiement')->primary();
            $table->decimal('montant_paiement', 10, 2);
            $table->string('mode_paiement')->nullable();
            $table->string('statut_paiement')->default('pending')->comment('pending, completed, failed');
            $table->unsignedBigInteger('commande_id');
            $table->foreign('commande_id')->references('id_commande')->on('commandes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['commande_id']);
            $table->dropColumn('commande_id');
        });
    }
};

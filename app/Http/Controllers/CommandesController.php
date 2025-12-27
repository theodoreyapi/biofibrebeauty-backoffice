<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('login');
        }

        $commandes = Commandes::join('clients', 'commandes.client_id', '=', 'clients.id_client')
            ->join('produits', 'commandes.produit_id', '=', 'produits.id_produit')
            ->select('commandes.*', 'clients.nom_complet', 'clients.telephone', 'produits.nom_produit', 'produits.image_produit')
            ->orderBy('commandes.created_at', 'desc')
            ->get();

        return view('gestion-commande', compact('commandes'));
    }

    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut_commande' => 'required|in:pending,paid,completed,cancelled'
        ]);

        DB::beginTransaction();

        try {
            $commande = Commandes::with('paiement')->findOrFail($id);
            $paiement = $commande->paiement;

            switch ($request->statut_commande) {

                case 'pending':
                    $commande->statut_commande = 'pending';
                    $paiement->statut_paiement = 'pending';
                    break;

                case 'paid':
                    $commande->statut_commande = 'paid';
                    $paiement->statut_paiement = 'completed';
                    break;

                case 'completed':
                    // sécurité métier
                    if ($paiement->statut_paiement !== 'completed') {
                        return response()->json([
                            'success' => false,
                            'message' => 'La commande doit être payée avant livraison'
                        ], 422);
                    }

                    $commande->statut_commande = 'completed';
                    break;

                case 'cancelled':
                    $commande->statut_commande = 'cancelled';
                    $paiement->statut_paiement = 'failed';
                    break;
            }

            $commande->save();
            $paiement->save();

            DB::commit();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

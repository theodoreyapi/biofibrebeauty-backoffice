<?php

namespace App\Http\Controllers;

use App\Models\Produits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('login');
        }

        $stockFaible = Produits::where('stock_produit', '<=', 5)->get();

        return view('stocks', compact('stockFaible'));
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
        $categorie = Produits::findOrFail($id);

        $roles = [
            'stock' => 'required',
        ];
        $customMessages = [
            'stock.required' => "Veuillez saisir le stock du produit.",
        ];

        $request->validate($roles, $customMessages);

        $categorie->stock_produit = $request->stock;

        if ($categorie->save()) {
            return back()->with('succes', "Vous avez modifier avec succès.");
        } else {
            return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
        }
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $produit = Produits::findOrFail($id);
        $produit->stock_produit = $request->stock;
        $produit->save();

        return response()->json([
            'success' => true,
            'stock' => $produit->stock_produit
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

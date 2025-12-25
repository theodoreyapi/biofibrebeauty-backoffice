<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Longueurs;
use App\Models\Produits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('login');
        }

        $produits = Produits::join('categories', 'produits.categorie_id', '=', 'categories.id_categorie')
            ->join('longueurs', 'produits.longueur_id', '=', 'longueurs.id_longueur')
            ->select('produits.*', 'categories.nom_categorie', 'longueurs.valeur_longueur')
            ->get();
        $categories = Categories::all();
        $longueurs = Longueurs::all();
        return view('produits', compact('produits', 'categories', 'longueurs'));
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
        $timestamp = Carbon::now()->format('Ymd_His');

        $roles = [
            'libelle' => 'required',
            'description' => 'nullable',
            'prix' => 'required',
            'couleur' => 'required',
            'longueur' => 'required',
            'stock' => 'required',
            'categorie' => 'required',
            'image' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le nom du produit.",
            'prix.required' => "Veuillez saisir le prix du produit.",
            'couleur.required' => "Veuillez saisir la couleur du produit.",
            'longueur.required' => "Veuillez sélectionner la longueur du produit.",
            'stock.required' => "Veuillez saisir le stock du produit.",
            'categorie.required' => "Veuillez sélectionner la catégorie du produit.",
            'image.required' => "Veuillez choisir l'image du produit.",
        ];

        $request->validate($roles, $customMessages);

        if ($request->file('image') !== null) {
            $diplome = $request->file('image');
            $diplomeName = 'produit_' . $timestamp . '.' . $diplome->getClientOriginalExtension();
            $diplome->move(public_path('produits'), $diplomeName);
            $diplomePath = url('admin/public/produits/' . $diplomeName);
        }

        $categorie = new Produits();
        $categorie->nom_produit = $request->libelle;
        $categorie->couleur_produit = $request->couleur;
        $categorie->description_produit = $request->description;
        $categorie->prix_produit = $request->prix;
        $categorie->stock_produit = $request->stock ?? 0;
        $categorie->categorie_id = $request->categorie;
        $categorie->longueur_id = $request->longueur;
        $categorie->image_produit = $diplomePath;
        if ($categorie->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->libelle);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->libelle . ". Veuillez réessayer!!"]);
        }
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

        $timestamp = Carbon::now()->format('Ymd_His');

        $roles = [
            'libelle' => 'required',
            'description' => 'nullable',
            'prix' => 'required',
            'couleur' => 'required',
            'longueur' => 'required',
            'stock' => 'required',
            'categorie' => 'required',
            'image' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le nom du produit.",
            'prix.required' => "Veuillez saisir le prix du produit.",
            'couleur.required' => "Veuillez saisir la couleur du produit.",
            'longueur.required' => "Veuillez sélectionner la longueur du produit.",
            'stock.required' => "Veuillez saisir le stock du produit.",
            'categorie.required' => "Veuillez sélectionner la catégorie du produit.",
            'image.required' => "Veuillez choisir l'image du produit.",
        ];

        $request->validate($roles, $customMessages);

        if ($request->file('image') !== null) {
            $diplome = $request->file('image');
            $diplomeName = 'produit_' . $timestamp . '.' . $diplome->getClientOriginalExtension();
            $diplome->move(public_path('produits'), $diplomeName);
            $diplomePath = url('admin/public/produits/' . $diplomeName);

            $categorie->image_produit = $diplomePath;
        }

        if ($categorie->nom_produit !== $request->libelle) {
            $categorie->nom_produit = $request->libelle;
        }
        if ($categorie->prix_produit !== $request->prix) {
            $categorie->prix_produit = $request->prix;
        }
        if ($categorie->categorie_id !== $request->categorie) {
            $categorie->categorie_id = $request->categorie;
        }
        if ($categorie->longueur_id !== $request->longueur) {
            $categorie->longueur_id = $request->longueur;
        }
        if ($categorie->stock_produit !== $request->stock) {
            $categorie->stock_produit = $request->stock ?? 0;
        }

        $categorie->couleur_produit = $request->couleur;
        $categorie->description_produit = $request->description;

        if ($categorie->save()) {
            return back()->with('succes', "Vous avez modifier avec succès.");
        } else {
            return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Produits::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}

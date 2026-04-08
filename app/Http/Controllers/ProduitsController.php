<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Longueurs;
use App\Models\ProduitImage;
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
            ->with('images')
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

        $request->validate([
            'libelle'     => 'required',
            'description' => 'nullable',
            'prix'        => 'required',
            'couleur'     => 'required',
            'longueur'    => 'required',
            'stock'       => 'required',
            'categorie'   => 'required',
            'images'      => 'required|array|min:1',
            'images.*'    => 'image',
        ], [
            'libelle.required'   => "Veuillez saisir le nom du produit.",
            'prix.required'      => "Veuillez saisir le prix du produit.",
            'couleur.required'   => "Veuillez saisir la couleur du produit.",
            'longueur.required'  => "Veuillez sélectionner la longueur du produit.",
            'stock.required'     => "Veuillez saisir le stock du produit.",
            'categorie.required' => "Veuillez sélectionner la catégorie du produit.",
            'images.required'    => "Veuillez choisir au moins une image.",
        ]);

        $produit = new Produits();
        $produit->nom_produit         = $request->libelle;
        $produit->couleur_produit     = $request->couleur;
        $produit->description_produit = $request->description;
        $produit->prix_produit        = $request->prix;
        $produit->stock_produit       = $request->stock ?? 0;
        $produit->categorie_id        = $request->categorie;
        $produit->longueur_id         = $request->longueur;
        $produit->save();

        // Enregistrement des images
        foreach ($request->file('images') as $index => $file) {
            $fileName = 'produit_' . $timestamp . '_' . $index . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('produits'), $fileName);

            ProduitImage::create([
                'produit_id'    => $produit->id_produit,
                'image_produit' => url('admin/public/produits/' . $fileName),
            ]);
        }

        return back()->with('succes', "Vous avez ajouté " . $request->libelle);
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
        $produit   = Produits::findOrFail($id);
        $timestamp = Carbon::now()->format('Ymd_His');

        $request->validate([
            'libelle'     => 'required',
            'description' => 'nullable',
            'prix'        => 'required',
            'couleur'     => 'required',
            'longueur'    => 'required',
            'stock'       => 'required',
            'categorie'   => 'required',
            'images'      => 'nullable|array',
            'images.*'    => 'image|max:2048',
        ], [
            'libelle.required'   => "Veuillez saisir le nom du produit.",
            'prix.required'      => "Veuillez saisir le prix du produit.",
            'couleur.required'   => "Veuillez saisir la couleur du produit.",
            'longueur.required'  => "Veuillez sélectionner la longueur du produit.",
            'stock.required'     => "Veuillez saisir le stock du produit.",
            'categorie.required' => "Veuillez sélectionner la catégorie du produit.",
        ]);

        $produit->nom_produit         = $request->libelle;
        $produit->couleur_produit     = $request->couleur;
        $produit->description_produit = $request->description;
        $produit->prix_produit        = $request->prix;
        $produit->stock_produit       = $request->stock ?? 0;
        $produit->categorie_id        = $request->categorie;
        $produit->longueur_id         = $request->longueur;

        // Nouvelles images (ajout sans supprimer les existantes)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $fileName = 'produit_' . $timestamp . '_' . $index . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('produits'), $fileName);

                ProduitImage::create([
                    'produit_id'    => $produit->id_produit,
                    'image_produit' => url('admin/public/produits/' . $fileName),
                ]);
            }
        }

        // Suppression d'images individuelles cochées
        if ($request->has('delete_images')) {
            ProduitImage::whereIn('id_produit_image', $request->delete_images)
                ->where('produit_id', $produit->id_produit)
                ->delete();
        }

        if ($produit->save()) {
            return back()->with('succes', "Vous avez modifié avec succès.");
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

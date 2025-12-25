<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('login');
        }

        $categories = Categories::all();

        return view('categories', compact('categories'));
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
        $roles = [
            'categorie' => 'required',
        ];
        $customMessages = [
            'categorie.required' => "Veuillez saisir le nom de la catégorie.",
        ];

        $request->validate($roles, $customMessages);

        $categorie = new Categories();
        $categorie->nom_categorie = $request->categorie;
        if ($categorie->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->categorie);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->categorie . ". Veuillez réessayer!!"]);
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
        $categorie = Categories::findOrFail($id);

        $roles = [
            'categorie' => 'required',
        ];
        $customMessages = [
            'categorie.required' => "Veuillez saisir le nom de la catégorie.",
        ];

        $request->validate($roles, $customMessages);

        if ($categorie->nom_categorie !== $request->categorie) {
            $categorie->nom_categorie = $request->categorie;
        }

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
        Categories::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}

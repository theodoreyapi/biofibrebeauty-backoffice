<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('login');
        }

        $clients = Clients::all();

        return view('clients', compact('clients'));
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
        $categorie = Clients::findOrFail($id);

        $roles = [
            'categorie' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'categorie.required' => "Veuillez saisir son nom complet.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($categorie->nom_complet !== $request->categorie) {
            $categorie->nom_complet = $request->categorie;
        }

        if ($categorie->statut_client !== $request->statut) {
            $categorie->statut_client = $request->statut;
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
        //
    }
}

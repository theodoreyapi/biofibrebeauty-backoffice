<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clients;
use App\Models\Commandes;
use App\Models\Longueurs;
use App\Models\Paiements;
use App\Models\Produits;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $roles = [
            'email' => 'required',
            'password' => 'required',
        ];
        $customMessages = [
            'email.required' => "Veuillez saisir son adresse email.",
            'password.required' => "Veuillez saisir son mot de passe.",
        ];

        $request->validate($roles, $customMessages);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            Auth::login($user);
            return redirect()->intended('index');
        } else {
            return back()->withErrors(['E-mail ou mot de passe incorrect.']);
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {

            $revenus = Paiements::where('statut_paiement', 'completed')
                ->sum('montant_paiement');

            $commandesEnAttente = Commandes::where('statut_commande', 'pending')->count();

            $produitsCount = Produits::count();

            $stockFaible = Produits::where('stock_produit', '<=', 5)->count();

            $clientsCount = Clients::count();
            $categoriesCount = Categories::count();
            $longueursCount = Longueurs::count();

            $commandesRecentes = Commandes::with('client')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact(
                'revenus',
                'commandesEnAttente',
                'produitsCount',
                'stockFaible',
                'clientsCount',
                'categoriesCount',
                'longueursCount',
                'commandesRecentes'
            ));
        } else {
            return view('login');
        }
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}

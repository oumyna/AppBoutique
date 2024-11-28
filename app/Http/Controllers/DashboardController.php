<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleModel;
use App\Models\User;
use App\Models\Facturation;
use App\Models\Vendeur;
use App\Models\Livreur;
use App\Models\Produit;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Récupération des données pour le tableau de bord
        $data = [
            'users' => User::count(),
            'roles' => RoleModel::count(),
            'facturations' => Facturation::count(),
            'vendeurs' => Vendeur::count(),
            'commandes' => Facturation::count(), // Vérifiez que c'est correct
            'fournisseurs' => Fournisseur::count(),
            'livreurs' => Livreur::count(),
            'produits' => Produit::count(),
        ];

        // Retourner la vue avec les données
        return view('panel.dashboard', compact('data'));
    }

    // Ajoutez des méthodes pour rediriger vers les listes
    public function listUsers()
    {
        return redirect()->route('panel.user.list');
    }

    public function listProduits()
    {
        return redirect()->route('panel.produit.list');
    }

    public function listCommandes()
    {
        return redirect()->route('commande.list');
    }
}
